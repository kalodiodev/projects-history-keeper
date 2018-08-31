<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\IntegrationTestCase;

class UserEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_user_edit()
    {
        $this->signInAdmin();

        $user = create(User::class);

        $this->get(route('user.edit', ['user' => $user->id]))
            ->assertStatus(200)
            ->assertViewIs('user.edit')
            ->assertViewHas('user', $user->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_user_edit()
    {
        $this->signInDefault();

        $user = create(User::class);

        $this->get(route('user.edit', ['user' => $user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_user_edit()
    {
        $user = create(User::class);

        $this->get(route('user.edit', ['user' => $user->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_update_a_user()
    {
        $this->signInAdmin();

        $user = create(User::class);

        $this->patch(route('user.update', ['user' => $user->id]), $this->userValidFields())
            ->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', array_merge([
            'id' => $user->id,
        ], $this->userValidFields()));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_a_user()
    {
        $this->signInDefault();

        $user = create(User::class);

        $this->patch(route('user.update', ['user' => $user->id]), $this->userValidFields())
            ->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_user()
    {
        $user = create(User::class);

        $this->patch(route('user.update', ['user' => $user->id]), $this->userValidFields())
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function authorized_user_can_update_himself_with_role_without_permission_to_manage_users()
    {
        $auth = $this->signInAdmin();

        $role = Role::whereName('default')->first();

        $this->patch(route('user.update', ['user' => $auth->id]), $this->userValidFields(['role_id' => $role->id]))
            ->assertRedirect('/');
    }

    /**
     * Get user valid fields data
     *
     * @param array $overrides
     * @return array
     */
    protected function userValidFields($overrides = [])
    {
        return array_merge([
            'name'    => 'User name',
            'role_id' => 1
        ], $overrides);
    }

}
