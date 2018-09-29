<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class ProfileTest extends IntegrationTestCase
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
            ->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'id'     => $user->id,
            'name'   => $this->validProfileFields()['name'],
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

    /**
     * Get valid user profile fields
     *
     * @param array $overrides
     * @return array
     */
    protected function validProfileFields($overrides = [])
    {
        return [
            'name'   => 'New name',
            'slogan' => 'A new slogan',
            'bio'    => 'A new bio'
        ];
    }
}
