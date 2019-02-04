<?php

namespace Tests\Feature;

use App\Task;
use App\Guide;
use App\Project;
use App\Snippet;
use Tests\IntegrationTestCase;

class RecordActivityTest extends IntegrationTestCase
{
    /** @test */
    public function creating_a_project()
    {
        $project = create(Project::class);

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created_project', $project->activity->last()->description);
    }

    /** @test */
    function creating_a_new_task()
    {
        $project = create(Project::class);
        create(Task::class, ['project_id' => $project->id]);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /** @test */
    function creating_a_guide()
    {
        $guide = create(Guide::class);

        $this->assertCount(1, $guide->activity);
        $this->assertEquals('created_guide', $guide->activity->last()->description);
    }

    /** @test */
    function creating_a_snippet()
    {
        $snippet = create(Snippet::class);

        $this->assertCount(1, $snippet->activity);
        $this->assertEquals('created_snippet', $snippet->activity->last()->description);
    }
}