<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invitation extends Model
{
    use Notifiable;

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

        static::created(function ($invitation) {
            $invitation->sendInvitationNotification();
        });
    }

    /**
     * Send Invitation notification with registration token
     */
    public function sendInvitationNotification()
    {
        $this->notify(new Notifications\Invitation($this->token));
    }
}
