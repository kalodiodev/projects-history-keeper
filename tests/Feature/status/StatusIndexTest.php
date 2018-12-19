<?php

namespace Tests\Feature\status;

use Tests\IntegrationTestCase;

class StatusIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_statuses_index()
    {
        $this->signInAdmin();

        $response = $this->get(route('status.index'))
            ->assertStatus(200)
            ->assertViewIs('status.index');

        $statuses = $response->original->getData()['statuses'];
        $this->assertEquals(2, $statuses->count());
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_view_statuses_index()
    {
        $this->signInDefault();
        
        $this->get(route('status.index'))
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_view_statuses_index()
    {
        $this->get(route('status.index'))
            ->assertRedirect(route('login'));
    }
}
