<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->token = str_random(25);
        });
    }
}
