<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class GuideCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_guide_create()
    {
        $this->signInAdmin();

        $this->get(route('guide.create'))
            ->assertStatus(200)
            ->assertViewIs('guide.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_guide_create()
    {
        $this->signInRestricted();

        $this->get(route('guide.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_guide_create()
    {
        $this->get(route('guide.create'))
            ->assertRedirect(route('login'));
    }
}
