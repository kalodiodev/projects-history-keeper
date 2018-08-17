<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class TagCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_create_tag()
    {
        $this->signInAdmin();

        $this->get(route('tag.create'))
            ->assertStatus(200)
            ->assertViewIs('tag.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_create_tag()
    {
        $this->signInDefault();

        $this->get(route('tag.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_create_tag()
    {
        $this->get(route('tag.create'))
            ->assertRedirect(route('login'));
    }
}