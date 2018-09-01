<?php

namespace App\Policies;

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

}
