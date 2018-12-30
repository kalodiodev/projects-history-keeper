<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether user can create a comment
     *
     * @param User $user
     * @param $commentable
     * @return bool
     */
    public function create(User $user, $commentable)
    {
        return $user->hasPermission('comment-create') && $user->can('view', $commentable);
    }
}
