<?php

namespace Tests\Unit;

use App\Role;
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

    /** @test */
    public function a_user_belongs_to_a_role()
    {
        $this->seed(\DatabaseSeeder::class);

        $user = make(User::class);

        $this->assertInstanceOf('App\Role', $user->role);
    }

    /** @test */
    public function a_role_can_be_assigned_to_user()
    {
        $user = create(User::class);

        $user->giveRole($role = create(Role::class));

        $this->assertDatabaseHas('users', [
            'id'      => $user->id,
            'role_id' => $role->id
        ]);
    }

    /** @test */
    public function it_determines_if_user_has_the_given_role()
    {
        $admin = create(Role::class);
        $john = create(User::class, ['role_id' => $admin->id]);

        $this->assertTrue($john->hasRole($admin->name));
        $this->assertTrue($john->hasRole($admin));

        $simpleUser = create(Role::class);
        $jane = create(User::class, ['role_id' => $simpleUser->id]);

        $this->assertFalse($jane->hasRole($admin->name));
        $this->assertFalse($jane->hasRole($admin));
    }
}
