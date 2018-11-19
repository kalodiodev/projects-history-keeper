<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
    ];
    
    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * A role has many users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * A role belongs to many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Give permission to role
     *
     * @param Permission $permission
     * @return Model
     */
    public function grantPermission($permission)
    {
        if($permission instanceof Permission) {
            return $this->permissions()->save($permission);
        }

        if((is_array($permission)) && (array_key_exists('name', $permission))) {
            return $this->grantPermission(Permission::whereName($permission['name'])->firstOrFail());
        }

        if($permission) {
            return $this->grantPermission(Permission::whereName($permission)->firstOrFail());
        }
    }

    /**
     * Give permissions to role
     *
     * @param array $permissions
     */
    public function grantPermissions(array $permissions)
    {
        foreach ($permissions as $permission)
        {
            $this->grantPermission($permission);
        }
    }

    /**
     * Assign this role to user
     *
     * @param User $user
     * @return false|Model
     */
    public function assignRoleTo(User $user)
    {
        return $this->users()->save($user);
    }

    /**
     * Determine if role is assigned to any user
     * 
     * @return bool
     */
    public function isAssigned()
    {
        return $this->users->count() >  0;
    }

    /**
     * Determine if role is locked
     *
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }
}
