<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'code',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
    ];

    /**
     * A snippet belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A guide belongs to many tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Determine whether snippet has given tag
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
