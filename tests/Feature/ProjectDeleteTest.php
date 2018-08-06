<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class ProjectDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_delete_a_project()
    {
        $this->signIn();

        $project = create(Project::class);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertRedirect(route('project.index'));

        $this->assertDatabaseMissing('projects', [
            'id'          => $project->id,
            'title'       => $project->title,
            'description' => $project->description
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_project()
    {
        $project = create(Project::class);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', [
            'id'          => $project->id,
            'title'       => $project->title,
            'description' => $project->description
        ]);
    }
}
