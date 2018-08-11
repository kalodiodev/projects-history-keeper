<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create Project policy
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('project-create');
    }
}
