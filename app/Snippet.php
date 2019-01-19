<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
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
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('title', 'LIKE', '%'. $term . '%')
            ->orWhere('description', 'LIKE', '%' . $term . '%')
            ->orWhere('code', 'LIKE', '%' . $term . '%');
    }
}
