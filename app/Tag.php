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

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($tag) {
            $tag->projects()->detach();
            $tag->guides()->detach();
        });
    }

    /**
     * Tag belongs to many projects
     */
    public function projects()
    {
        return $this->morphedByMany(Project::class, 'taggable');
    }

    /**
     * Tag belongs to many guides
     */
    public function guides()
    {
        return $this->morphedByMany(Guide::class, 'taggable');
    }
}
