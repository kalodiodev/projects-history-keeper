<?php

namespace Tests\Feature;

use App\User;
use App\Task;
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

    /** @test */
    public function an_authenticated_user_can_store_a_task()
    {
        $this->signIn($user = create(User::class));

        $project = create(Project::class);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertRedirect(route('project.show', ['project' => $project->id]));

        $this->assertDatabaseHas('tasks', [
            'project_id'  => $project->id,
            'user_id'     => $user->id,
            'title'       => $task->title,
            'description' => $task->description,
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_task()
    {
        $project = create(Project::class);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tasks', [
            'title'       => $task->title,
            'description' => $task->description
        ]);
    }

    /** @test */
    public function a_task_cannot_be_stored_for_a_non_existent_project()
    {
        $this->signIn();

        $non_existent_project_id = 4;
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $non_existent_project_id]), $task->toArray())
            ->assertStatus(404);
    }
}
