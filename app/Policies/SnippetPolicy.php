<?php

namespace App\Policies;

use App\Snippet;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SnippetPolicy
{
    use HandlesAuthorization;

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
}
