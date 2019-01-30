<?php

namespace Tests\Feature;

use App\Guide;
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
        $this->assertEquals('created_project', $project->activity->last()->description);
    }

    /** @test */
    function creating_a_new_task_records_project_activity()
    {
        $project = create(Project::class);
        create(Task::class, ['project_id' => $project->id]);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /** @test */
    function creating_a_guide_records_guide_activity()
    {
        $guide = create(Guide::class);

        $this->assertCount(1, $guide->activity);
        $this->assertEquals('created_guide', $guide->activity->last()->description);
    }
}