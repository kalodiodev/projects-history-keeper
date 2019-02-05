<?php

namespace App\Observers;

use App\Guide;
use Illuminate\Support\Facades\Storage;

class GuideObserver
{
    /**
     * Handle the guide "created" event.
     *
     * @param  \App\Guide  $guide
     * @return void
     */
    public function created(Guide $guide)
    {
        $guide->activity()->create([
            'description' => 'created_guide'
        ]);
    }

    /**
     * Handle the guide "deleting" event.
     *
     * @param  \App\Guide  $guide
     * @return void
     */
    public function deleting(Guide $guide)
    {
        if ($guide->featured_image && Storage::has($guide->featured_image)) {
            Storage::delete($guide->featured_image);
        }

        $guide->images()->delete();
    }
}
