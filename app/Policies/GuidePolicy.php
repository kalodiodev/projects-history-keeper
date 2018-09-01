<?php

namespace App\Policies;

use App\Guide;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuidePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create guide.
     *
     * @param User $user user that creates a project
     * @return bool true if user has permission to create a project, otherwise false
     */
    public function create(User $user)
    {
        return $user->hasPermission('guide-create');
    }

    /**
     * Determine whether the user can index guides
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasPermission('guide-view') || $user->hasPermission('guide-view-any');
    }

    /**
     * Determine whether the user can view guides.
     *
     * @param User $user
     * @param Guide $guide
     * @return bool
     */
    public function view(User $user, Guide $guide)
    {
        if($user->hasPermission('guide-view-any')) {
            return true;
        }

        return (($user->hasPermission('guide-view')) && ($user->ownsGuide($guide)));
    }

    /**
     * Determine whether the user can view any guide.
     *
     * @param User $user
     * @return bool
     */
    public function view_all(User $user)
    {
        return $user->hasPermission('guide-view-any');
    }
}
