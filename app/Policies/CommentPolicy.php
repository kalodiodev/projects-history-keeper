<?php

namespace App\Policies;

use App\Comment;
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

    /**
     * Determine whether user can delete comment
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        if ($user->hasPermission('comment-delete-any'))
        {
            return true;
        }

        return $user->hasPermission('comment-delete') && $comment->creator->id == $user->id;
    }
}
