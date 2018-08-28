<?php

namespace Tests\Feature;

use App\Invitation;
use Tests\IntegrationTestCase;

class UserRegisterTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_with_invitation_token_can_view_registration_form()
    {
        $invitation = create(Invitation::class);

        $this->get(route('register', ['invitation' => $invitation->token]))
            ->assertStatus(200)
            ->assertViewIs('auth.register');
    }

    /** @test */
    public function a_user_with_invalid_token_cannot_view_registration_form()
    {
        $this->get(route('register', ['invitation' => 'invalid']))
            ->assertStatus(404);
    }
    
    /** @test */
    public function a_user_with_invitation_token_can_register()
    {
        $invitation = create(Invitation::class);
        
        $this->post(route('register', ['invitation' => $invitation->token]), [
            'name' => 'My name',
            'email' => $invitation->email,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ])->assertStatus(302);

        $this->assertDatabaseHas('users', ['email' => $invitation->email]);
        $this->assertDatabaseMissing('invitations', ['email' => $invitation->email]);
    }
    
    /** @test */
    public function a_user_with_invalid_token_cannot_register()
    {
        $this->post(route('register', ['invitation' => 'invalid']), [
            'name' => 'My name',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ])->assertStatus(404);

        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }
}
