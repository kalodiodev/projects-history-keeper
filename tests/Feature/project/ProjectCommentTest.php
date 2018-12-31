<?php

namespace Tests\Feature;

use App\Comment;
use App\Project;
use Tests\IntegrationTestCase;

class ProjectCommentTest extends IntegrationTestCase
{
    /** @test */
    public function project_view_contains_project_comments()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->get(route('project.show', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewHas(['project', 'comments']);
    }

    /** @test */
    public function an_authorized_user_can_post_a_project_comment()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->post(route('project.comment.store', ['project' => $project->id]), [
                'comment' => 'My comment'
            ])
            ->assertRedirect(route('project.show', ['project' => $project->id]))
            ->assertSessionHas('message');;

        $this->assertDatabaseHas('comments', [
            'comment' => 'My comment',
            'commentable_id' => $project->id,
            'commentable_type' => 'App\Project'
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_post_a_project_comment()
    {
        $project = create(Project::class);

        $this->post(route('project.comment.store', ['project' => $project->id]), [
            'comment' => 'My comment'
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_post_a_project_comment()
    {
        $this->signInRestricted();

        $project = create(Project::class);

        $this->post(route('project.comment.store', ['project' => $project->id]), [
            'comment' => 'My comment'
        ])->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_a_project_comment()
    {
        $this->signInAdmin();

        $comment = create(Comment::class, ['commentable_type' => 'App\Project']);

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

        $comment = create(Comment::class, ['commentable_type' => 'App\Project']);

        $this->delete(route('comment.destroy', ['comment' => $comment->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function a_default_user_cannot_delete_other_users_comments()
    {
        $this->signInDefault();

        $comment = create(Comment::class, ['commentable_type' => 'App\Project']);

        $this->delete(route('comment.destroy', ['comment' => $comment->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function a_comment_requires_a_comment_body()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->post(route('project.comment.store', ['project' => $project->id]), [
                'comment' => ''
            ])
            ->assertSessionHasErrors(['comment']);
    }
}