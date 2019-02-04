<?php

namespace App\Observers;

use App\Project;
use App\Status;

class ProjectObserver
{
    /**
     * Handle the project "creating" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function creating(Project $project)
    {
        if (! isset($project->status_id)) {
            $project->status_id = Status::first()->id;
        }
    }

    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project->activity()->create([
            'description' => 'created_project'
        ]);
    }

    /**
     * Handle the project "deleting" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleting(Project $project)
    {
        $project->tags()->detach();
        $project->tasks()->delete();
        $project->images()->delete();
    }
}
