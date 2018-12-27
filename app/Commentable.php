<?php

namespace App;

trait Commentable
{
    /**
     * A project has many comments
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}