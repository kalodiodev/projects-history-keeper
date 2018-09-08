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
}
