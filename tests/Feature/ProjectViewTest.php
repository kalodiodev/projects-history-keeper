<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class ProjectViewTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_view_a_project()
    {
        $this->signIn();

        $project = create(Project::class);

        $this->get(route('project.show', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.show')
            ->assertViewHas('project', $project->fresh());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_project()
    {
        $project = create(Project::class);

        $this->get(route('project.show', ['project' => $project->id]))
            ->assertRedirect(route('login'));
    }
}
