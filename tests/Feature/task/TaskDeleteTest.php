<?php

namespace Tests\Feature;

use App\Task;
use Tests\IntegrationTestCase;

class TaskDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_delete_his_task()
    {
        $user = $this->signInDefault();

        $task = create(Task::class, ['user_id' => $user->id]);

        $this->delete(route('project.task.destroy', ['task' => $task->id]))
            ->assertRedirect(route('project.show', ['project' => $task->project->id]))
            ->assertSessionHas('message');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => $task->title
        ]);
    }

    /** @test */
    public function a_user_cannot_delete_others_tasks()
    {
        $this->signInDefault();

        $task = create(Task::class);

        $this->delete(route('project.task.destroy', ['task' => $task->id]))
            ->assertStatus(403);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $task->title
        ]);
    }

    /** @test */
    public function an_authorized_user_can_delete_any_task()
    {
        $this->signInAdmin();

        $task = create(Task::class);

        $this->delete(route('project.task.destroy', ['task' => $task->id]))
            ->assertRedirect(route('project.show', ['project' => $task->project->id]))
            ->assertSessionHas('message');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => $task->title
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_any_task()
    {
        $user = $this->signInRestricted();

        $task = create(Task::class, ['user_id' => $user->id]);

        $this->delete(route('project.task.destroy', ['task' => $task->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_task()
    {
        $task = create(Task::class);

        $this->delete(route('project.task.destroy', ['task' => $task->id]))
            ->assertRedirect(route('login'));
    }
}
