<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use Taggable, Commentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'body',
        'featured_image',
        'user_id',
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
     * Guide belongs to a creator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * A guide has many images
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Activity feed for the project
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'recordable');
    }


    /**
     * Determine whether guide has featured image
     * 
     * @return bool
     */
    public function hasFeaturedImage()
    {
        if ($this->featured_image != null && ! empty($this->featured_image)) {
            return true;
        }

        return false;
    }

    /**
     * Search for guides that contain the given term
     *
     * @param $query
     * @param $term
     * @return mixed
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'LIKE', '%'. $term . '%')
            ->orWhere('description', 'LIKE', '%' . $term . '%')
            ->orWhere('body', 'LIKE', '%' . $term . '%');
    }
}
