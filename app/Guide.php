<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Guide extends Model
{
    use Taggable;

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

    use SlugTrait {
        boot as slug_boot;
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        self::slug_boot();

        static::deleting(function ($guide) {
            if ($guide->featured_image && Storage::has($guide->featured_image)) {
                Storage::delete($guide->featured_image);
            }

            $guide->images()->delete();
        });
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
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
}
