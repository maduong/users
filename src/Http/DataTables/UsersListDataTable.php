<?php namespace Edutalk\Base\Users\Http\DataTables;

use Illuminate\Database\Eloquent\SoftDeletes;
use Edutalk\Base\Http\DataTables\AbstractDataTables;
use Edutalk\Base\Users\Models\User;
use Edutalk\Base\Users\Repositories\Contracts\UserRepositoryContract;
use Edutalk\Base\Users\Repositories\UserRepository;
use Yajra\Datatables\Engines\CollectionEngine;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class UsersListDataTable extends AbstractDataTables
{
    /**
     * @var User
     */
    protected $model;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var array|\Illuminate\Http\Request|string
     */
    protected $request;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->model = User::select('id', 'created_at', 'avatar', 'username', 'email', 'status', 'sex', 'deleted_at')
            ->withTrashed();

        $this->request = request();

        $this->repository = $repository;
    }

    public function headings()
    {
        return [
            'avatar' => [
                'title' => trans('edutalk-users::datatables.heading.avatar'),
                'width' => '1%',
            ],
            'username' => [
                'title' => trans('edutalk-users::datatables.heading.username'),
                'width' => '10%',
            ],
            'email' => [
                'title' => trans('edutalk-users::datatables.heading.email'),
                'width' => '15%',
            ],
            'status' => [
                'title' => trans('edutalk-users::datatables.heading.status'),
                'width' => '5%',
            ],
            'created_at' => [
                'title' => trans('edutalk-users::datatables.heading.created_at'),
                'width' => '10%',
            ],
            'roles' => [
                'title' => trans('edutalk-users::datatables.heading.roles'),
                'width' => '15%',
            ],
            'actions' => [
                'title' => trans('edutalk-core::datatables.heading.actions'),
                'width' => '20%',
            ],
        ];
    }

    public function columns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'searchable' => false, 'orderable' => false],
            ['data' => 'avatar', 'name' => 'avatar', 'searchable' => false, 'orderable' => false],
            ['data' => 'username', 'name' => 'username'],
            ['data' => 'email', 'name' => 'email'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'roles', 'name' => 'roles', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('admin::users.index.post'), 'POST');

        $this
            ->addFilter(2, form()->text('username', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('edutalk-core::datatables.search') . '...',
            ]))
            ->addFilter(3, form()->email('email', '', [
                'class' => 'form-control form-filter input-sm',
                'placeholder' => trans('edutalk-core::datatables.search') . '...',
            ]))
            ->addFilter(4, form()->select('status', [
                '' => trans('edutalk-core::datatables.select') . '...',
                'activated' => trans('edutalk-core::base.status.activated'),
                'disabled' => trans('edutalk-core::base.status.disabled'),
                'deleted' => trans('edutalk-core::base.status.deleted'),
            ], '', ['class' => 'form-control form-filter input-sm']));

        $this->withGroupActions([
            '' => trans('edutalk-core::datatables.select') . '...',
            'deleted' => trans('edutalk-core::datatables.delete_these_items'),
            'activated' => trans('edutalk-core::datatables.active_these_items'),
            'disabled' => trans('edutalk-core::datatables.disable_these_items'),
        ]);

        return $this->view();
    }

    /**
     * @return CollectionEngine|EloquentEngine|QueryBuilderEngine|mixed
     */
    protected function fetchDataForAjax()
    {
        return datatable()->of($this->model)
            ->rawColumns(['actions', 'avatar'])
            ->filterColumn('status', function ($query, $keyword) {
                /**
                 * @var UserRepository $query
                 */
                if ($keyword === 'deleted') {
                    return $query->onlyTrashed();
                } else {
                    return $query->where('status', '=', $keyword);
                }
            })
            ->editColumn('avatar', function ($item) {
                return '<img src="' . get_image($item->avatar) . '" width="50" height="50">';
            })
            ->editColumn('id', function ($item) {
                return form()->customCheckbox([['id[]', $item->id]]);
            })
            ->editColumn('status', function ($item) {
                /**
                 * @var SoftDeletes $item
                 */
                if ($item->trashed()) {
                    return html()->label(trans('edutalk-core::base.status.deleted'), 'deleted');
                }
                return html()->label(trans('edutalk-core::base.status.' . $item->status), $item->status);
            })
            ->addColumn('roles', function ($item) {
                $result = [];
                $roles = $this->repository->getRoles($item);
                if ($roles) {
                    foreach ($roles as $key => $row) {
                        $result[] = $row->name;
                    }
                }
                return implode(', ', $result);
            })
            ->addColumn('actions', function ($item) {
                /*Edit link*/
                $activeLink = route('admin::users.update-status.post', ['id' => $item->id, 'status' => 'activated']);
                $disableLink = route('admin::users.update-status.post', ['id' => $item->id, 'status' => 'disabled']);
                $deleteLink = route('admin::users.delete.delete', ['id' => $item->id]);
                $forceDelete = route('admin::users.force-delete.delete', ['id' => $item->id]);
                $restoreLink = route('admin::users.restore.post', ['id' => $item->id]);

                /*Buttons*/
                $editBtn = link_to(route('admin::users.edit.get', ['id' => $item->id]), trans('edutalk-core::datatables.edit'), ['class' => 'btn btn-outline green btn-sm']);
                $activeBtn = ($item->status != 'activated' && !$item->trashed()) ? form()->button('Active', [
                    'title' => trans('edutalk-core::datatables.active_this_item'),
                    'data-ajax' => $activeLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';
                $disableBtn = ($item->status != 'disabled' && !$item->trashed()) ? form()->button(trans('edutalk-core::datatables.disable'), [
                    'title' => trans('edutalk-core::datatables.disable_this_item'),
                    'data-ajax' => $disableLink,
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';
                $deleteBtn = (!$item->trashed())
                    ? form()->button(trans('edutalk-core::datatables.delete'), [
                        'title' => trans('edutalk-core::datatables.delete_this_item'),
                        'data-ajax' => $deleteLink,
                        'data-method' => 'DELETE',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    ])
                    : form()->button(trans('edutalk-core::datatables.force_delete'), [
                        'title' => trans('edutalk-core::datatables.force_delete_this_item'),
                        'data-ajax' => $forceDelete,
                        'data-method' => 'DELETE',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                    ]) . form()->button(trans('edutalk-core::datatables.restore'), [
                        'title' => trans('edutalk-core::datatables.restore_this_item'),
                        'data-ajax' => $restoreLink,
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline blue btn-sm ajax-link',
                    ]);

                $activeBtn = ($item->status != 'activated') ? $activeBtn : '';
                $disableBtn = ($item->status != 'disabled') ? $disableBtn : '';

                return $editBtn . $activeBtn . $disableBtn . $deleteBtn;
            });
    }
}
