<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'color'];

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * A status has many projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Determine whether status is assigned to any project
     */
    public function isAssigned()
    {
        return $this->projects->count() >  0;
    }
}
