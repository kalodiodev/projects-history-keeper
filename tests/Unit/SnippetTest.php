<?php

namespace Tests\Unit;

use App\User;
use App\Snippet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SnippetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_snippet_belongs_to_a_user()
    {
        $snippet = make(Snippet::class);

        $this->assertInstanceOf(User::class, $snippet->creator);
    }

    /** @test */
    public function a_snippet_belongs_to_tags()
    {
        $snippet = make(Snippet::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $snippet->tags
        );
    }
}