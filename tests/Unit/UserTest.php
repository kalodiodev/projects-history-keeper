<?php

namespace Tests\Unit;

use App\Guide;
use App\User;
use App\Role;
use App\Task;
use App\Project;
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

    /** @test */
    public function it_determines_if_user_is_projects_creator()
    {
        $user = create(User::class);
        $usersProject = create(Project::class, ['user_id' => $user->id]);
        $othersProject = create(Project::class);

        $this->assertTrue($user->ownsProject($usersProject));
        $this->assertFalse($user->ownsProject($othersProject));
    }

    /** @test */
    public function it_determines_if_user_is_tasks_creator()
    {
        $user = create(User::class);
        $usersTask = create(Task::class, ['user_id' => $user->id]);
        $othersTask = create(Task::class);

        $this->assertTrue($user->ownsTask($usersTask));
        $this->assertFalse($user->ownsTask($othersTask));
    }

    /** @test */
    public function a_user_has_guides()
    {
        $user = create(User::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $user->guides
        );
    }

    /** @test */
    public function it_determines_if_user_is_guides_creator()
    {
        $user = create(User::class);
        $usersGuide = create(Guide::class, ['user_id' => $user->id]);
        $othersGuide = create(Guide::class);

        $this->assertTrue($user->ownsGuide($usersGuide));
        $this->assertFalse($user->ownsGuide($othersGuide));
    }
}
