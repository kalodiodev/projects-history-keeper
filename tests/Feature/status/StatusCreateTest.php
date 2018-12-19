<?php

namespace Tests\Feature\status;

use Tests\IntegrationTestCase;

class StatusCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_status_create()
    {
        $this->signInAdmin();

        $this->get(route('status.create'))
            ->assertStatus(200)
            ->assertViewIs('status.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_status_create()
    {
        $this->signInDefault();

        $this->get(route('status.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_status_create()
    {
        $this->get(route('status.create'))
            ->assertRedirect(route('login'));
    }
}
