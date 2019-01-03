<?php

namespace Tests\Feature;

use App\Comment;
use Tests\IntegrationTestCase;

class CommentDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_delete_a_project_comment()
    {
        $this->signInAdmin();

        $comment = create(Comment::class);

        $this->delete(route('comment.destroy', ['comment' => $comment->id]));

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_project_comment()
    {
        $comment = create(Comment::class, ['commentable_type' => 'App\Project']);

        $this->delete(route('comment.destroy', ['comment' => $comment->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_project_comment()
    {
        $this->signInRestricted();

        $comment = create(Comment::class);

        $this->delete(route('comment.destroy', ['comment' => $comment->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function a_default_user_cannot_delete_other_users_comments()
    {
        $this->signInDefault();

        $comment = create(Comment::class);

        $this->delete(route('comment.destroy', ['comment' => $comment->id]))
            ->assertStatus(403);
    }
}