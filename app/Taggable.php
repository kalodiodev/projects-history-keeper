<?php

namespace App;

trait Taggable
{
    /**
     * Model belongs to many tags
     *
     * @return mixed
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Determine whether model has given tag
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

    /**
     * Taggables of Tag
     *
     * @param $query
     * @param $tagName
     * @return mixed
     */
    public function scopeOfTag($query, $tagName)
    {
        return $query->with('tags')->whereHas('tags', function($query) use ($tagName) {
            $query->where('name', 'LIKE', $tagName);
        });
    }
}