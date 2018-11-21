<?php

namespace Tests\Unit;

use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_belongs_to_a_user()
    {
        $task = make(Task::class);

        $this->assertInstanceOf('App\User', $task->creator);
    }

    /** @test */
    public function it_should_return_a_soft_deleted_creator()
    {
        $user = create(User::class);
        $task = create(Task::class, ['user_id' => $user->id]);
        $user->delete();

        $this->assertInstanceOf('App\User', $task->fresh()->creator);
    }

    /** @test */
    public function a_task_belongs_to_a_project()
    {
        $task = make(Task::class);

        $this->assertInstanceOf('App\Project', $task->project);
    }
}