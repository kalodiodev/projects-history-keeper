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

        $this->httpGetTaskEdit(['user_id' => $user->id])
            ->assertStatus(200)
            ->assertViewIs('task.edit');
    }

    /** @test */
    public function a_user_cannot_view_task_edit_for_others_tasks()
    {
        $this->signInDefault();

        $this->httpGetTaskEdit()->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_task_edit_for_any_task()
    {
        $this->signInAdmin();

        $this->httpGetTaskEdit()
            ->assertStatus(200)
            ->assertViewIs('task.edit');
    }

    /** @test */
    public function an_authorized_cannot_view_edit_task_for_any_task()
    {
        $user = $this->signInRestricted();

        $this->httpGetTaskEdit(['user_id' => $user->id])
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_a_task()
    {
        $this->httpGetTaskEdit()->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_update_his_task()
    {
        $user = $this->signInDefault();

        $task = create(Task::class, ['user_id' => $user->id]);

        $this->patch(route('project.task.update', ['task' => $task->id]), $this->taskValidFields())
            ->assertRedirect(route('project.show', ['project' => $task->project->id]));

        $this->assertDatabaseHas('tasks', $this->taskValidFields(['id'  => $task->id]));
    }

    /** @test */
    public function a_user_cannot_update_others_tasks()
    {
        $this->signInDefault();

        $task = create(Task::class);

        $this->patch(route('project.task.update', ['task' => $task->id]), $this->taskValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_update_any_task()
    {
        $this->signInAdmin();

        $task = create(Task::class);

        $this->patch(route('project.task.update', ['task' => $task->id]), $this->taskValidFields())
            ->assertRedirect(route('project.show', ['project' => $task->project->id]));

        $this->assertDatabaseHas('tasks', $this->taskValidFields(['id'  => $task->id]));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_any_task()
    {
        $user = $this->signInRestricted();

        $task = create(Task::class, ['user_id' => $user->id]);

        $this->patch(route('project.task.update', ['task' => $task->id]), $this->taskValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_can_update_a_task()
    {
        $task = create(Task::class);

        $this->patch(route('project.task.update', ['task' => $task->id]), $this->taskValidFields())
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tasks', $task->fresh()->toArray());
    }

    /** @test */
    public function a_task_requires_title()
    {
        $this->signIn();

        $this->httpPatchTask(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function task_title_length_should_within_the_right_limits()
    {
        $this->signIn();

        $this->httpPatchTask(['title' => str_random(4)])
            ->assertSessionHasErrors(['title']);

        $this->httpPatchTask(['title' => str_random(192)])
            ->assertSessionHasErrors(['title']);
    }


    /** @test */
    public function task_date_must_be_of_type_date()
    {
        $this->signIn();

        $this->httpPatchTask(['date' => "2018-08-07"])
            ->assertSessionHasNoErrors();

        $this->httpPatchTask(['date' => 'a string'])
            ->assertSessionHasErrors(['date']);
    }

    /**
     * Task Data
     *
     * @param array $overrides
     * @return array
     */
    protected function taskValidFields($overrides = [])
    {
        return array_merge([
            'title'   => 'New Title',
            'description' => 'New Description',
            'date'    => '2018-12-31'
        ], $overrides);
    }

    /**
     * HTTP GET Task Edit
     *
     * @param array $task_overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function httpGetTaskEdit($task_overrides = [])
    {
        $task = create(Task::class, $task_overrides);

        return $this->get(route('project.task.edit', ['task' => $task->id]));
    }

    /**
     * HTTP Patch a Task
     *
     * @param $withData
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function httpPatchTask($withData)
    {
        $task = create(Task::class);

        $withData = array_merge($task->toArray(), $withData);

        return $this->patch(route('project.task.update', ['task' => $task->id]), $withData);
    }
}
