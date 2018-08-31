<?php

namespace Tests\Feature;

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

}
