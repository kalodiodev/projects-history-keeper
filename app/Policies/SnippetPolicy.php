<?php

namespace App\Policies;

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
}
