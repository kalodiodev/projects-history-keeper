<?php

namespace App;

trait SlugTrait
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($entity) {
            static::setSlug($entity);
        });

        static::updating(function ($entity) {
            if($entity->title != static::where('id', $entity->id)->firstOrFail()->title) {
                static::setSlug($entity);
            }
        });
    }

    /**
     * Set slug to entity
     *
     * @param $entity
     */
    protected static function setSlug($entity)
    {
        //Create slug
        $entity->slug = str_slug($entity->title);
        //Check if slug already exists
        if (static::whereSlug($entity->slug)->exists()) {
            //Get latest created slug
            $latestSlug = static::whereRaw("slug RLIKE '^{$entity->slug}(-[0-9]*)?$'")
                ->latest('id')
                ->pluck('slug');
            if ($latestSlug) {
                $pieces = explode('-', $latestSlug);
                $number = intval(end($pieces));
                $entity->slug .= '-' . ($number + 1);
            }
        }
    }
}