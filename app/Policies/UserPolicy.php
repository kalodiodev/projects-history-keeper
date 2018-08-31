<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage users.
     *
     * @param User $user
     * @return bool
     */
    public function manage(User $user)
    {
        return $user->hasPermission('user-invite') || $user->hasPermission('user-edit');
    }

    /**
     * Determine whether the user can edit users.
     *
     * @param User $user
     * @return bool
     */
    public function edit(User $user)
    {
        return $user->hasPermission('user-edit');
    }

    /**
     * Determine whether the user can create a new user
     *
     * @param User $user
     * @return bool
     */
    public function invite(User $user)
    {
        return $user->hasPermission('user-invite');
    }
}
