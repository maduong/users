<?php namespace Edutalk\Base\Users\Hook;

use Edutalk\Base\Users\Repositories\Contracts\UserRepositoryContract;
use Edutalk\Base\Users\Repositories\UserRepository;

class RegisterDashboardStats
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        echo view('edutalk-users::admin.dashboard-stats.stat-box', [
            'count' => $this->repository->count(),
        ]);
    }
}
