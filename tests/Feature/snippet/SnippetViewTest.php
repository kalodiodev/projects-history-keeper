<?php

namespace Tests\Feature;

use App\Snippet;
use Tests\IntegrationTestCase;

class SnippetViewTest extends IntegrationTestCase
{
    /** @test */
    public function a_snippet_can_be_viewed_by_its_creator()
    {
        $user = $this->signInDefault();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->get(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertStatus(200)
            ->assertViewIs('snippet.show')
            ->assertViewHas('snippet', $snippet->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_other_creators_snippets()
    {
        $this->signInDefault();

        $snippet = create(Snippet::class);

        $this->get(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_any_snippet()
    {
        $this->signInAdmin();

        $snippet = create(Snippet::class);

        $this->get(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertStatus(200)
            ->assertViewIs('snippet.show')
            ->assertViewHas('snippet', $snippet->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_any_snippet()
    {
        $this->signInRestricted();

        $snippet = create(Snippet::class);

        $this->get(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_snippet()
    {
        $snippet = create(Snippet::class);

        $this->get(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertRedirect(route('login'));
    }
}
