<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        $user = make(User::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $user->projects
        );
    }

    /** @test */
    public function a_user_has_tasks()
    {
        $user = make(User::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $user->tasks
        );
    }
}
