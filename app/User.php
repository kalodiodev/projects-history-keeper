<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user belongs to a role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * A user has many projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * A user has many tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Assign a role to user
     *
     * @param $role
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function giveRole($role)
    {
        if($role instanceof Role) {
            return $role->assignRoleTo($this);
        }

        return Role::whereName($role)
            ->firstOrFail()
            ->assignRoleTo($this);
    }

    /**
     * Determine if user has the given role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->role->name == $role;
        }

        if($role instanceof Role) {
            return $role->name == $this->role->name;
        }

        return $role->contains('name', $this->role->name);
    }

    /**
     * Determine if user has the given permission
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if(is_string($permission)) {
            return $this->hasRole(
                Permission::whereName($permission)->firstOrFail()->roles
            );
        }

        return $this->hasRole($permission->roles);
    }

    /**
     * Determine if user owns the given project
     *
     * @param Project $project project user may own
     * @return bool true if user is projects creator, otherwise false
     */
    public function ownsProject(Project $project)
    {
        return $this->id === $project->user_id;
    }
}
