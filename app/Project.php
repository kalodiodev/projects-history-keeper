<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Taggable;
    
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
            $project->tasks()->delete();
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
}
