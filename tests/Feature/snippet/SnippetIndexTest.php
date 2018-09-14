<?php

namespace Tests\Feature;

use App\Snippet;
use Tests\IntegrationTestCase;

class SnippetIndexTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_own_snippets_index()
    {
        $user = $this->signInDefault();

        // signed in user's snippets
        create(Snippet::class, ['user_id' => $user->id], 2);

        // other users snippets
        create(Snippet::class, [], 2);

        $response = $this->get(route('snippet.index'))
            ->assertStatus(200)
            ->assertViewIs('snippet.index')
            ->assertViewHas('snippets');

        $snippets = $response->original->getData()['snippets'];
        $this->assertEquals(2, $snippets->count());
    }

    /** @test */
    public function an_authorized_user_can_view_all_snippets_index()
    {
        $user = $this->signInAdmin();

        // signed in user's snippets
        create(Snippet::class, ['user_id' => $user->id], 2);

        // other users snippets
        create(Snippet::class, [], 2);

        $response = $this->get(route('snippet.index'))
            ->assertStatus(200)
            ->assertViewIs('snippet.index')
            ->assertViewHas(['snippets']);

        $snippets = $response->original->getData()['snippets'];
        $this->assertEquals(4, $snippets->count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_snippets()
    {
        $this->signInRestricted();

        $this->get(route('snippet.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_snippets_index()
    {
        $this->get(route('snippet.index'))
            ->assertRedirect(route('login'));
    }
}
