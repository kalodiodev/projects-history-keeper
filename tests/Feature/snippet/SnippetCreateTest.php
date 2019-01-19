<?php

namespace Tests\Feature;

use App\Snippet;
use App\Tag;
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
            ->assertRedirect(route('snippet.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('snippets', $this->snippetValidFields());
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_snippet()
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

    /** @test */
    public function a_snippet_requires_a_valid_title()
    {
        $this->signInDefault();

        $this->post(route('snippet.store'), $this->snippetValidFields(['title' => '']))
            ->assertSessionHasErrors(['title']);

        $this->post(route('snippet.store'), $this->snippetValidFields(['title' => str_random(121)]))
            ->assertSessionHasErrors(['title']);

        $this->post(route('snippet.store'), $this->snippetValidFields(['title' => str_random(2)]))
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function a_snippet_can_have_a_valid_description()
    {
        $this->signInDefault();

        $this->post(route('snippet.store'), $this->snippetValidFields(['description' => str_random(192)]))
            ->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function a_snippet_requires_a_code()
    {
        $this->signInDefault();

        $this->post(route('snippet.store'), $this->snippetValidFields(['code' => '']))
            ->assertSessionHasErrors(['code']);
    }

    /** @test */
    public function tags_can_be_attached_to_snippet()
    {
        $this->signInAdmin();

        $tags = create(Tag::class, [], 3);

        $this->post(
            route('snippet.store'),
            $this->snippetValidFields(['tags' => $tags->pluck('id')->toArray()])
        );

        $snippet = Snippet::first();

        $this->assertEquals(3, $snippet->tags->count());
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
