<?php namespace Edutalk\Base\Users\Repositories;

use Illuminate\Support\Collection;
use Edutalk\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use Edutalk\Base\Repositories\Eloquent\EloquentBaseRepository;
use Edutalk\Base\Users\Models\Contracts\UserModelContract;
use Edutalk\Base\Users\Models\User;
use Edutalk\Base\Users\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends EloquentBaseRepository implements UserRepositoryContract
{
    use EloquentUseSoftDeletes;

    /**
     * @param User|int $user
     * @param array $data
     */
    public function syncRoles($user, array $data)
    {
        if (!$user instanceof User) {
            $user = $this->find($user);
        }
        try {
            $user->roles()->sync($data);
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param User|int $user
     * @return Collection
     */
    public function getRoles($user)
    {
        if (!$user instanceof User) {
            $user = $this->find($user);
        }
        if ($user) {
            return $user->roles()->get();
        }
        return collect([]);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getRelatedRoleIds($user)
    {
        if ($user) {
            return $user->roles()->allRelatedIds()->toArray();
        }
        return [];
    }

    /**
     * @param array $data
     * @return int
     */
    public function createUser(array $data, array $roles = null)
    {
        $user = $this->create($data);
        if ($user && $roles !== null) {
            $this->syncRoles($user, $roles);
        }
        return $user;
    }

    /**
     * @param User|int $id
     * @param array $data
     * @return int
     */
    public function updateUser($id, array $data, array $roles = null)
    {
        $resultEditObject = $this->update($id, $data);

        if (!$resultEditObject) {
            return $resultEditObject;
        }

        if ($roles !== null) {
            $this->syncRoles($id, $roles);
        }

        return $resultEditObject;
    }

    /**
     * @param User|int $user
     * @return bool
     */
    public function isSuperAdmin($user)
    {
        if (!$user instanceof User) {
            $user = $this->find($user);
        }

        if (!$user || !$user->isSuperAdmin()) {
            return false;
        }

        return true;
    }

    /**
     * @param User|int $user
     * @param array $permissions
     * @return bool
     */
    public function hasPermission($user, array $permissions)
    {
        if (!$user instanceof User) {
            $user = $this->find($user);
        }

        if (!$user || !$user->hasPermission($permissions)) {
            return false;
        }

        return true;
    }

    /**
     * @param User|int $user
     * @param array $roles
     * @return bool
     */
    public function hasRole($user, array $roles)
    {
        if (!$user instanceof User) {
            $user = $this->find($user);
        }

        if (!$user || !$user->hasRole($roles)) {
            return false;
        }

        return true;
    }
}
