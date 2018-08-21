<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class UserCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_user_create()
    {
        $this->signInAdmin();

        $this->get(route('user.create'))
            ->assertStatus(200)
            ->assertViewIs('user.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_user_create()
    {
        $this->signInDefault();

        $this->get(route('user.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_user_create()
    {
        $this->get(route('user.create'))
            ->assertRedirect(route('login'));
    }
}
