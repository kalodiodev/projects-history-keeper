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
        'status_id',
        'title',
        'description'
    ];

    protected $with = [
        'images'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'status_id' => 'int'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            $project->tags()->detach();
            $project->tasks()->delete();
            $project->images()->delete();
        });

        static::creating(function ($project) {
            if (! isset($project->status_id)) {
                $project->status_id = Status::first()->id;
            }
        });
    }

    /**
     * A project belongs to a creator (user)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
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
     * A project has many images
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * A project belongs to a status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
