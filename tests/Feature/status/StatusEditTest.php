<?php

namespace Tests\Feature\status;

use App\Status;
use Tests\IntegrationTestCase;

class StatusEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_status_edit()
    {
        $this->signInAdmin();

        $status = create(Status::class);

        $this->get(route('status.edit', ['status' => $status->id]))
            ->assertStatus(200)
            ->assertViewIs('status.edit')
            ->assertViewHas('status', $status->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_status_edit()
    {
        $this->signInDefault();

        $status = create(Status::class);

        $this->get(route('status.edit', ['status' => $status->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_status_edit()
    {
        $status = create(Status::class);

        $this->get(route('status.edit', ['status' => $status->id]))
            ->assertRedirect(route('login'));
    }
}