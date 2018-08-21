<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;

class UserIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_users_index()
    {
        create(User::class, [], 3);
        $this->signInAdmin();

        $response = $this->get(route('user.index'))
            ->assertStatus(200)
            ->assertViewIs('user.index');

        // Total users are 4, 1 the signed in user and 3 others created
        $users = $response->original->getData()['users'];
        $this->assertEquals(4, $users->count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_users_index()
    {
        $this->signInDefault();

        $this->get(route('user.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_users_index()
    {
        $this->get(route('user.index'))
            ->assertRedirect(route('login'));
    }
}
