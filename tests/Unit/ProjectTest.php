<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_a_creator()
    {
        $project = make(Project::class);

        $this->assertInstanceOf('App\User', $project->creator);
    }

    /** @test */
    public function a_project_has_tasks()
    {
        $project = make(Project::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $project->tasks
        );
    }

    /** @test */
    public function a_project_belongs_to_tags()
    {
        $project = make(Project::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $project->tags
        );
    }
}
