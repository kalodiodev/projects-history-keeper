<?php

namespace Tests\Feature\status;

use App\Status;
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

    /** @test */
    public function an_authorized_user_can_store_a_status()
    {
        $this->signInAdmin();

        $status = make(Status::class);

        $this->post(route('status.store'), $status->toArray())
            ->assertRedirect(route('status.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('statuses', [
            'title' => $status->title,
            'color' => $status->color
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_status()
    {
        $this->signInDefault();
        
        $status = make(Status::class);

        $this->post(route('status.store'), $status->toArray())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_status()
    {
        $status = make(Status::class);

        $this->post(route('status.store'), $status->toArray())
            ->assertRedirect(route('login'));
    }
}
