<?php

namespace App\Policies;

use App\Task;
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
    public function create(User $user, Project $project)
    {
        if($user->hasPermission('task-create-any')) {
            return true;
        }

        return (($user->hasPermission('task-create')) && ($user->ownsProject($project)));
    }

    /**
     * Determine whether the user can update task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        if($user->hasPermission('task-update-any')) {
            return true;
        }

        return (($user->hasPermission('task-update')) && ($user->ownsTask($task)));
    }

    /**
     * Determine whether the user can delete task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function delete(User $user, Task $task)
    {
        if($user->hasPermission('task-delete-any')) {
            return true;
        }

        return (($user->hasPermission('task-delete')) && ($user->ownsTask($task)));
    }
}
