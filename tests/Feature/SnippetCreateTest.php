<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class SnippetCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_snippet_create()
    {
        $this->signInDefault();

        $this->get(route('snippet.create'))
            ->assertViewIs('snippet.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_snippet_create()
    {
        $this->signInRestricted();

        $this->get(route('snippet.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_snippet_create()
    {
        $this->get(route('snippet.create'))
            ->assertRedirect(route('login'));
    }
}
