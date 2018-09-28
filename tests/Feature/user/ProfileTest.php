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
}
