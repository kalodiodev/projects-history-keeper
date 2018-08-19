<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage task.
     *
     * @param User $user
     * @return bool
     */
    public function manage(User $user)
    {
        return ($user->hasPermission('tag-create') ||
            $user->hasPermission('tag-update') ||
            $user->hasPermission('tag-delete'));
    }

    /**
     * Determine whether the user can create task.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('tag-create');
    }

    /**
     * Determine whether the user can update tasks.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('tag-update');
    }

    /**
     * Determine whether the user can delete tasks.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('tag-delete');
    }
}
