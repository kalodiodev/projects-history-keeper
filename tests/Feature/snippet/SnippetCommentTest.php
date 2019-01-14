<?php

namespace Tests\Feature;

use App\Snippet;
use Tests\IntegrationTestCase;

class SnippetCommentTest extends IntegrationTestCase
{
    /** @test */
    public function snippet_view_contains_snippet_comments()
    {
        $this->signInAdmin();

        $snippet = create(Snippet::class);

        $this->get(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertStatus(200)
            ->assertViewHas(['snippet', 'comments']);
    }
}