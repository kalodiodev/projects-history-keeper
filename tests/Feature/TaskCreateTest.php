<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class TaskCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_create_a_task()
    {
        $this->signIn();

        $project = create(Project::class);

        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('task.create');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_task()
    {
        $project = create(Project::class);

        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_task_cannot_be_created_for_a_non_existent_project()
    {
        $this->signIn();

        $non_existent_project_id = 4;

        $this->get(route('project.task.create', ['project' => $non_existent_project_id]))
            ->assertStatus(404);
    }
}
