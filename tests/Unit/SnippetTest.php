<?php

namespace Tests\Unit;

use App\Tag;
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
    public function it_should_return_a_soft_deleted_user()
    {
        $user = create(User::class);
        $snippet = create(Snippet::class, ['user_id' => $user->id]);
        $user->delete();
        
        $this->assertInstanceOf(User::class, $snippet->fresh()->creator);
    }

    /** @test */
    public function a_snippet_belongs_to_tags()
    {
        $snippet = make(Snippet::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $snippet->tags
        );
    }

    /** @test */
    public function it_determines_whether_snippet_has_given_tag()
    {
        $tag = create(Tag::class);
        $snippet = create(Snippet::class);

        $snippet->tags()->attach($tag);

        $this->assertTrue($snippet->hasTag($tag));
        $this->assertFalse($snippet->hasTag(100));
    }
}