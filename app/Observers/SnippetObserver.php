<?php

namespace App\Observers;

use App\Snippet;

class SnippetObserver
{
    /**
     * Handle the snippet "created" event.
     *
     * @param  \App\Snippet  $snippet
     * @return void
     */
    public function created(Snippet $snippet)
    {
        $snippet->activity()->create([
            'description' => 'created_snippet'
        ]);
    }
}
