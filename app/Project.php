<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
    ];


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            $project->tags()->detach();
        });
    }

    /**
     * A project belongs to a creator (user)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A project has many tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * A project belongs to many tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Determine whether project has given tag
     *
     * @param $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        if($tag instanceof Tag) {
            $tag = $tag->id;
        }

        return $this->tags()->whereId($tag)->first() != null;
    }

}
