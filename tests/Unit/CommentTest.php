<?php

namespace Tests\Unit;

use App\Comment;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_has_a_creator()
    {
        $comment = create(Comment::class);

        $this->assertInstanceOf('App\User', $comment->creator);
    }

    /** @test */
    public function a_comment_belongs_to_commentable_model()
    {
        $comment = create(Comment::class);

        $this->assertInstanceOf(Model::class, $comment->commentable);
    }
}