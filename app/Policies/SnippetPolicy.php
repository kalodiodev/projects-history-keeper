<?php

namespace App\Policies;

use App\Snippet;
use App\User;
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
        return $user->hasPermission('snippet-view') || $user->hasPermission('snippet-view-any');
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
        if($user->hasPermission('snippet-view-any')) {
            return true;
        }

        return (($user->hasPermission('snippet-view')) && ($user->ownsSnippet($snippet)));
    }

    /**
     * Determine whether the user can view any snippet.
     *
     * @param User $user
     * @return bool
     */
    public function view_all(User $user)
    {
        return $user->hasPermission('snippet-view-any');
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
