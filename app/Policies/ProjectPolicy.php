<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether user can index projects
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        $permissions_required = [
            'project-create',
            'project-update',
            'project-delete',
            'project-view-any',
            'project-update-any',
            'project-delete-any',
        ];

        return $user->hasAnyOfPermissions($permissions_required);
    }

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

    /**
     * View project policy
     * 
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Project $project)
    {
        if($user->hasPermission('project-view-any') ||
            $user->hasPermission('project-update-any') ||
            $user->hasPermission('project-delete-any'))
        {
            return true;
        }
        
        return $user->ownsProject($project);
    }

    /**
     * View all projects policy
     *
     * @param User $user
     * @return bool
     */
    public function view_all(User $user)
    {
        return $user->hasPermission('project-view-any') ||
            $user->hasPermission('project-update-any') ||
            $user->hasPermission('project-delete-any');
    }

    /**
     * Determine whether the user can store image to project
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function upload_image(User $user, Project $project)
    {
        if($user->hasPermission('image-store-any-project')) {
            return true;
        }

        return $user->ownsProject($project);
    }
}
