<?php

namespace App\Policies;

use App\User;
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
}
