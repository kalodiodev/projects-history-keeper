<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;

class ProfileEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_view_own_profile_edit()
    {
        $this->signInDefault();

        $this->get(route('profile.edit'))
            ->assertViewIs('profile.edit');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_profile_edit()
    {
        $this->get(route('profile.edit'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_update_profile()
    {
        $user =$this->signInDefault();

        $this->patch(route('profile.update'), $this->validProfileFields())
            ->assertRedirect(route('home'))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('users', [
            'id'     => $user->id,
            'name'   => $this->validProfileFields()['name'],
            'email'  => $this->validProfileFields()['email'],
            'slogan' => $this->validProfileFields()['slogan'],
            'bio'    => $this->validProfileFields()['bio'],
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_profile()
    {
        $this->patch(route('profile.update'), $this->validProfileFields())
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function email_cannot_be_updated_with_an_existing_one()
    {
        create(User::class, ['email' => 'user@example.com']);

        $user = $this->signInDefault();

        $this->patch(route('profile.update'), $this->validProfileFields(['email' => 'user@example.com']))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email
        ]);
    }

    /**
     * Get valid user profile fields
     *
     * @param array $overrides
     * @return array
     */
    protected function validProfileFields($overrides = [])
    {
        return array_merge([
            'name'   => 'New name',
            'email'  => 'newmail@example.com',
            'slogan' => 'A new slogan',
            'bio'    => 'A new bio'
        ], $overrides);
    }
}
