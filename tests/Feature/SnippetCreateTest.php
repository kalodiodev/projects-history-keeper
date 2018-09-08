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

    /** @test */
    public function an_authorized_user_can_store_a_snippet()
    {
        $this->signInDefault();

        $this->post(route('snippet.store'), $this->snippetValidFields())
            ->assertRedirect(route('snippet.index'));

        $this->assertDatabaseHas('snippets', $this->snippetValidFields());
    }

    /** @test */
    public function an_unauthorized_user_can_store_a_snippet()
    {
        $this->signInRestricted();

        $this->post(route('snippet.store'), $this->snippetValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_snippet()
    {
        $this->post(route('snippet.store'), $this->snippetValidFields())
            ->assertRedirect(route('login'));
    }

    /**
     * Get snippet valid fields data
     *
     * @param array $overrides
     * @return array
     */
    public function snippetValidFields($overrides = [])
    {
        return array_merge([
            'title' => 'My new snippet',
            'description' => 'My new snippet description',
            'code' => 'My code'
        ], $overrides);
    }
}
