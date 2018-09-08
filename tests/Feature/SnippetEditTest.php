<?php

namespace Tests\Feature;

use App\Snippet;
use Tests\IntegrationTestCase;

class SnippetEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_own_snippet_edit()
    {
        $user = $this->signInDefault();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->get(route('snippet.edit', ['snippet' => $snippet->id]))
            ->assertStatus(200)
            ->assertViewIs('snippet.edit')
            ->assertViewHas('snippet', $snippet->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_other_users_snippets_edit()
    {
        $this->signInDefault();

        $snippet = create(Snippet::class);

        $this->get(route('snippet.edit', ['snippet' => $snippet->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_any_snippet_edit()
    {
        $this->signInAdmin();

        $snippet = create(Snippet::class);

        $this->get(route('snippet.edit', ['snippet' => $snippet->id]))
            ->assertStatus(200)
            ->assertViewIs('snippet.edit')
            ->assertViewHas('snippet', $snippet->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_any_snippet_edit()
    {
        $user = $this->signInRestricted();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->get(route('snippet.edit', ['snippet' => $snippet->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_snippet_edit()
    {
        $snippet = create(Snippet::class);

        $this->get(route('snippet.edit', ['snippet' => $snippet->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_update_own_snippet()
    {
        $user = $this->signInDefault();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->patch(route('snippet.update', ['snippet' => $snippet->id]), $this->snippetValidFields())
            ->assertRedirect(route('snippet.index'));

        $this->assertDatabaseHas('snippets', array_merge([
            'id' => $snippet->id
        ], $this->snippetValidFields()));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_other_users_snippets()
    {
        $this->signInDefault();

        $snippet = create(Snippet::class);

        $this->patch(route('snippet.update', ['snippet' => $snippet->id]), $this->snippetValidFields())
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_authorized_user_can_update_any_snippet()
    {
        $this->signInAdmin();

        $snippet = create(Snippet::class);
        
        $this->patch(route('snippet.update', ['snippet' => $snippet->id]), $this->snippetValidFields())
            ->assertRedirect(route('snippet.index'));

        $this->assertDatabaseHas('snippets', array_merge([
            'id' => $snippet->id
        ], $this->snippetValidFields()));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_any_snippet()
    {
        $user = $this->signInRestricted();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->patch(route('snippet.update', ['snippet' => $snippet->id]), $this->snippetValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_snippet()
    {
        $snippet = create(Snippet::class);

        $this->patch(route('snippet.update', ['snippet' => $snippet->id]), $this->snippetValidFields())
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
