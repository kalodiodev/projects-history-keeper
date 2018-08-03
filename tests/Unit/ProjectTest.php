<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_a_creator()
    {
        $project = factory(\App\Project::class)->create();

        $this->assertInstanceOf('App\User', $project->creator);
    }
}
