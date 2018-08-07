<?php

namespace Tests\Feature;

use App\Task;
use Tests\IntegrationTestCase;

class TaskEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_edit_a_task()
    {
        $this->signIn();

        $task = create(Task::class);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertStatus(200)
            ->assertViewIs('task.edit');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_a_task()
    {
        $task = create(Task::class);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertRedirect(route('login'));
    }
}
