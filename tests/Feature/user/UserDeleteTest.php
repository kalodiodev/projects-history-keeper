<?php

namespace Tests\Feature\user;

use App\User;
use Tests\IntegrationTestCase;

class UserDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_soft_delete_a_user()
    {
        $this->signInAdmin();

        $user = create(User::class);

        $this->delete(route('user.destroy', ['user' => $user->id]))
            ->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
        $this->assertNotNull($user->fresh()->deleted_at);
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_user()
    {
        $user = create(User::class);
        
        $this->delete(route('user.destroy', ['user' => $user->id]))
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_delete_a_user()
    {
        $this->signInRestricted();
        
        $user = create(User::class);
        
        $this->delete(route('user.destroy', ['user' => $user->id]))
            ->assertStatus(403);
    }
}
