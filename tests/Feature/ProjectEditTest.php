<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class ProjectEditTest extends IntegrationTestCase
{
    /** @test */
    public function a_project_can_be_edited_by_its_creator()
    {
        $user = factory(\App\User::class)->create();
        $this->signIn($user);

        $project = factory(\App\Project::class)->create(['user_id' => $user->id]);

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.edit')
            ->assertViewHas('project');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_a_project()
    {
        $project = factory(\App\Project::class)->create();

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertRedirect(route('login'));
    }
}
