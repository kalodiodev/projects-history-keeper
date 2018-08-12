<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create Project policy
     *
     * @param User $user user that creates a project
     * @return bool true if user has permission to create a project, otherwise false
     */
    public function create(User $user)
    {
        return $user->hasPermission('project-create');
    }

    /**
     * Update project policy
     *
     * @param User $user user that updates project
     * @param Project $project project to be updated
     * @return bool true if user has permission to update project, otherwise false
     */
    public function update(User $user, Project $project)
    {
        if($user->hasPermission('project-update-any')) {
            return true;
        }

        return (($user->hasPermission('project-update')) && ($user->ownsProject($project)));
    }

    /**
     * Delete project policy
     *
     * @param User $user user that deletes project
     * @param Project $project project to be deleted
     * @return bool true if user has permission to delete project, otherwise false
     */
    public function delete(User $user, Project $project)
    {
        if($user->hasPermission('project-delete-any')) {
            return true;
        }

        return (($user->hasPermission('project-delete')) && ($user->ownsProject($project)));
    }
}
