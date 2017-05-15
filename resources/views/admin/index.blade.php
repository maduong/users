@extends('edutalk-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-1columns">
        <div class="column main">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="icon-layers font-dark"></i>
                        {{ trans('edutalk-users::base.all_users') }}
                    </h3>
                    <div class="box-tools">
                        <a class="btn green btn-sm"
                           href="{{ route('admin::users.create.get') }}">
                            <i class="fa fa-plus"></i> {{ trans('edutalk-core::base.form.create') }}
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    {!! $dataTable or '' !!}
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', EDUTALK_USERS . '.index', null) @endphp
        </div>
    </div>
@endsection
