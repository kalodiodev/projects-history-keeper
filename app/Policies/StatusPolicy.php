<?php

namespace App\Policies;

use App\User;
use App\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index statuses
     *
     * @param User $user
     * @return bool
     */
    public function manage(User $user)
    {
        $permissions_required = [
            'status-create',
            'status-delete',
            'status-update'
        ];

        return $user->hasAnyOfPermissions($permissions_required);
    }

    /**
     * Determine whether the user can create status
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('status-create');
    }

    /**
     * Determine whether the user can update status
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function update(User $user, Status $status)
    {
        return $user->hasPermission('status-update');
    }

    /**
     * Determine whether the user can delete status
     *
     * @param User $user
     * @param Status $status
     * @return bool
     */
    public function delete(User $user, Status $status)
    {
        return $user->hasPermission('status-delete');
    }
}
