<?php

namespace Tests\Feature\status;

use App\Project;
use App\Status;
use Tests\IntegrationTestCase;

class StatusDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_delete_a_status()
    {
        $this->signInAdmin();

        $status = create(Status::class);

        $this->delete(route('status.destroy', ['status' => $status->id]))
            ->assertRedirect(route('status.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseMissing('statuses', ['id' => $status->id]);
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_status()
    {
        $status = create(Status::class);
        
        $this->delete(route('status.destroy', ['status' => $status->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_status()
    {
        $this->signInDefault();

        $status = create(Status::class);

        $this->delete(route('status.destroy', ['status' => $status->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function a_status_in_use_cannot_be_deleted()
    {
        $this->signInAdmin();

        $status = create(Status::class);
        create(Project::class, ['status_id' => $status->id]);

        $this->delete(route('status.destroy', ['status' => $status->id]))
            ->assertRedirect(route('status.index'))
            ->assertSessionHas('error-message');

        $this->assertDatabaseHas('statuses', [
            'id' => $status->id,
            'title' => $status->title
        ]);
    }
}