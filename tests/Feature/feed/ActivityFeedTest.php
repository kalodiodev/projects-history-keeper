<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\IntegrationTestCase;

class ActivityFeedTest extends IntegrationTestCase
{
    /** @test */
    public function creating_a_project_records_activity()
    {
        $project = create(Project::class);

        $this->assertCount(1, $project->activity);
    }

    /** @test */
    function creating_a_new_task_records_project_activity()
    {
        $project = create(Project::class);
        create(Task::class, ['project_id' => $project->id]);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }
}