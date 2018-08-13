<?php

namespace Tests\Feature;

use App\Task;
use Tests\IntegrationTestCase;

class TaskEditTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_task_edit_for_his_task()
    {
        $user = $this->signInDefault();

        $task = create(Task::class, ['user_id' => $user->id]);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertStatus(200)
            ->assertViewIs('task.edit');
    }

    /** @test */
    public function a_user_cannot_view_task_edit_for_others_tasks()
    {
        $this->signInDefault();

        $task = create(Task::class);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_task_edit_for_any_task()
    {
        $this->signInAdmin();

        $task = create(Task::class);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertStatus(200)
            ->assertViewIs('task.edit');
    }

    /** @test */
    public function an_authorized_cannot_view_edit_task_for_any_task()
    {
        $user = $this->signInRestricted();

        $task = create(Task::class, ['user_id' => $user->id]);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_a_task()
    {
        $task = create(Task::class);

        $this->get(route('project.task.edit', ['task' => $task->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_update_his_task()
    {
        $user = $this->signInDefault();

        $task = create(Task::class, ['user_id' => $user->id]);

        $newData = [
            'title'   => 'New Title',
            'description' => 'New Description',
            'date'    => '2018-12-31'
        ];

        $this->patch(route('project.task.update', ['task' => $task->id]), $newData)
            ->assertRedirect(route('project.show', ['project' => $task->project->id]));

        $this->assertDatabaseHas('tasks', array_merge([
            'id'  => $task->id
        ], $newData));
    }

    /** @test */
    public function a_user_cannot_update_others_tasks()
    {
        $this->signInDefault();

        $task = create(Task::class);

        $newData = [
            'title'   => 'New Title',
            'description' => 'New Description',
            'date'    => '2018-12-31'
        ];

        $this->patch(route('project.task.update', ['task' => $task->id]), $newData)
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_update_any_task()
    {
        $this->signInAdmin();

        $task = create(Task::class);

        $newData = [
            'title'   => 'New Title',
            'description' => 'New Description',
            'date'    => '2018-12-31'
        ];

        $this->patch(route('project.task.update', ['task' => $task->id]), $newData)
            ->assertRedirect(route('project.show', ['project' => $task->project->id]));

        $this->assertDatabaseHas('tasks', array_merge([
            'id'  => $task->id
        ], $newData));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_any_task()
    {
        $user = $this->signInRestricted();

        $task = create(Task::class, ['user_id' => $user->id]);

        $newData = [
            'title'   => 'New Title',
            'description' => 'New Description',
            'date'    => '2018-12-31'
        ];

        $this->patch(route('project.task.update', ['task' => $task->id]), $newData)
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_can_update_a_task()
    {
        $task = create(Task::class);

        $newData = [
            'title'   => 'New Title',
            'description' => 'New Description',
            'date'    => '2018-12-31'
        ];

        $this->patch(route('project.task.update', ['task' => $task->id]), $newData)
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tasks', $task->fresh()->toArray());
    }

    /** @test */
    public function a_task_requires_title()
    {
        $this->signIn();

        $this->patchTask(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function task_title_length_should_within_the_right_limits()
    {
        $this->signIn();

        $this->patchTask(['title' => str_random(4)])
            ->assertSessionHasErrors(['title']);

        $this->patchTask(['title' => str_random(192)])
            ->assertSessionHasErrors(['title']);
    }


    /** @test */
    public function task_date_must_be_of_type_date()
    {
        $this->signIn();

        $this->patchTask(['date' => "2018-08-07"])
            ->assertSessionHasNoErrors();

        $this->patchTask(['date' => 'a string'])
            ->assertSessionHasErrors(['date']);
    }

    /**
     * Post a Task
     *
     * @param $withData
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function patchTask($withData)
    {
        $task = create(Task::class);

        $withData = array_merge($task->toArray(), $withData);

        return $this->patch(route('project.task.update', ['task' => $task->id]), $withData);
    }
}
