<?php

namespace Tests\Feature;

use App\Role;
use App\Project;
use Tests\IntegrationTestCase;

class ProjectDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function a_project_can_be_deleted_by_its_creator()
    {
        $user = $this->signInAs('default');

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertRedirect(route('project.index'));
        
        $this->assertDatabaseMissing('projects', [
            'id'          => $project->id,
            'title'       => $project->title,
            'description' => $project->description
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_others_projects()
    {
        $this->signInAs('default');

        $project = create(Project::class);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_delete_own_project()
    {
        create(Role::class, ['name' => 'restricted']);
        $user = $this->signInAs('restricted');

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->delete(route('project.destroy', ['project' => $project->id]))
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_authorized_user_can_delete_any_project()
    {
        $this->signInAs('admin');

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
