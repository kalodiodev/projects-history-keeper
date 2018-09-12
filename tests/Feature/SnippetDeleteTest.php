<?php

namespace Tests\Feature;

use App\Snippet;
use Tests\IntegrationTestCase;

class SnippetDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function a_snippet_can_be_deleted_by_its_creator()
    {
        $user = $this->signInDefault();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->delete(route('snippet.destroy', ['snippet' => $snippet->id]))
            ->assertRedirect(route('snippet.index'));

        $this->assertDatabaseMissing('snippets', $snippet->toArray());
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_other_users_snippets()
    {
        $this->signInDefault();

        $snippet = create(Snippet::class);

        $this->delete(route('snippet.destroy', ['snippet' => $snippet->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_any_snippet()
    {
        $user = $this->signInRestricted();

        $snippet = create(Snippet::class, ['user_id' => $user->id]);

        $this->delete(route('snippet.destroy', ['snippet' => $snippet->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_any_snippet()
    {
        $this->signInAdmin();

        $snippet = create(Snippet::class);

        $this->delete(route('snippet.destroy', ['snippet' => $snippet->id]))
            ->assertRedirect(route('snippet.index'));

        $this->assertDatabaseMissing('snippets', $snippet->toArray());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_snippet()
    {
        $snippet = create(Snippet::class);

        $this->delete(route('snippet.destroy', ['snippet' => $snippet->id]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('snippets', $snippet->toArray());
    }
}
