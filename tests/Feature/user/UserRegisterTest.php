<?php

namespace Tests\Feature;

use App\User;
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

        $this->registerUser($invitation, ['email' => $invitation->email])
            ->assertStatus(302);

        $this->assertDatabaseHas('users', ['email' => $invitation->email]);
        $this->assertDatabaseMissing('invitations', ['email' => $invitation->email]);
    }
    
    /** @test */
    public function a_user_with_invalid_token_cannot_register()
    {
        $this->post(route('register', ['invitation' => 'invalid']), $this->userValidFields())
            ->assertStatus(404);

        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }
    
    /** @test */
    public function a_user_requires_a_name()
    {
        $this->registerUser($invitation = create(Invitation::class), ['name' => ''])
            ->assertSessionHasErrors(['name']);
    }
    
    /** @test */
    public function a_user_requires_a_password()
    {
        $this->registerUser($invitation = create(Invitation::class), [
            'password' => '',
            'password_confirmation' => ''
        ])->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_password_must_be_at_least_six_chars_long()
    {
        $this->registerUser($invitation = create(Invitation::class), [
            'password' => '12345',
            'password_confirmation' => '12345'
        ])->assertSessionHasErrors(['password']);
    }
    
    /** @test */
    public function user_password_must_be_confirmed()
    {
        $this->registerUser(create(Invitation::class), ['password_confirmation' => ''])
            ->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_requires_a_valid_email()
    {
        $invitation = create(Invitation::class);
        
        $this->registerUser($invitation, ['email' => ''])
            ->assertSessionHasErrors(['email']);

        $this->registerUser($invitation, ['email' => 'invalid_email'])
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_must_be_unique()
    {
        create(User::class, ['email' => 'test@example.com']);

        $this->registerUser($invitation = create(Invitation::class), ['email' => 'test@example.com'])
            ->assertSessionHasErrors(['email']);
    }

    /**
     * Register User
     *
     * @param Invitation $invitation
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function registerUser(Invitation $invitation, array $overrides = [])
    {
        return $this->post(route(
            'register', 
            ['invitation' => $invitation->token]), 
            $this->userValidFields($overrides)
        );
    }

    /**
     * Get User valid fields data
     *
     * @param array $overrides
     * @return array
     */
    protected function userValidFields($overrides = [])
    {
        return array_merge([
            'name' => 'My name',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ], $overrides);
    }
}
