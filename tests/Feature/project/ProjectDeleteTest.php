<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class ProjectDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function a_project_can_be_deleted_by_its_creator()
    {
        $user = $this->signInDefault();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertRedirect(route('project.index'));
        
        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_others_projects()
    {
        $this->signInDefault();

        $project = create(Project::class);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_delete_own_project()
    {
        $user = $this->signInRestricted();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_authorized_user_can_delete_any_project()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertRedirect(route('project.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_project()
    {
        $project = create(Project::class);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', $project->toArray());
    }
}
