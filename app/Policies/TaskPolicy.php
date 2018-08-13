<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\User $user
     * @param Project $project
     * @return mixed
     */
    public function create(User $user, $project)
    {
        if($user->hasPermission('task-create-any')) {
            return true;
        }

        return (($user->hasPermission('task-create')) && ($user->ownsProject($project)));
    }
}
