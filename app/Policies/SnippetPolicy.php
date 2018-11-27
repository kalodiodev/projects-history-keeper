<?php

namespace App\Policies;

use App\User;
use App\Snippet;
use Illuminate\Auth\Access\HandlesAuthorization;

class SnippetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index snippets
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        $permissions_required = [
            'snippet-create',
            'snippet-update',
            'snippet-delete',
            'snippet-view-any',
            'snippet-update-any',
            'snippet-delete-any',
        ];

        return $user->hasAnyOfPermissions($permissions_required);
    }

    /**
     * Determine whether the user can view snippets.
     *
     * @param User $user
     * @param Snippet $snippet
     * @return bool
     */
    public function view(User $user, Snippet $snippet)
    {
        $required_permissions = [
            'snippet-view-any',
            'snippet-update-any',
            'snippet-delete-any'
        ];

        return $user->ownsSnippet($snippet) || $user->hasAnyOfPermissions($required_permissions);
    }

    /**
     * Determine whether the user can view any snippet.
     *
     * @param User $user
     * @return bool
     */
    public function view_all(User $user)
    {
        $required_permissions = [
            'snippet-view-any',
            'snippet-update-any',
            'snippet-delete-any'
        ];

        return $user->hasAnyOfPermissions($required_permissions);
    }


    /**
     * Determine whether the user can create snippet.
     *
     * @param User $user user that creates a snippet
     * @return bool true if user has permission to create a snippet, otherwise false
     */
    public function create(User $user)
    {
        return $user->hasPermission('snippet-create');
    }

    /**
     * Determine whether the user can update snippet.
     *
     * @param User $user user that updates snippet
     * @param Snippet $snippet snippet to update
     * @return bool true if user has permission to update snippet, otherwise false
     */
    public function update(User $user, Snippet $snippet)
    {
        if($user->hasPermission('snippet-update-any')) {
            return true;
        }

        return (($user->hasPermission('snippet-update')) && ($user->ownsSnippet($snippet)));
    }

    /**
     * Determine whether the user can delete snippet.
     *
     * @param User $user user that deletes snippet
     * @param Snippet $snippet snippet to be deleted
     * @return bool true if user has permission to delete snippet, otherwise false
     */
    public function delete(User $user, Snippet $snippet)
    {
        if($user->hasPermission('snippet-delete-any')) {
            return true;
        }

        return (($user->hasPermission('snippet-delete')) && ($user->ownsSnippet($snippet)));
    }

}
