<?php

namespace Tests\Unit;

use App\Task;
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
    public function a_task_belongs_to_a_project()
    {
        $task = make(Task::class);

        $this->assertInstanceOf('App\Project', $task->project);
    }
}