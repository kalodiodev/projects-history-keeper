<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Tag belongs to many projects
     */
    public function projects()
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }
}
