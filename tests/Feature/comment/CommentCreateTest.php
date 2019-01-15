<?php

namespace Tests\Feature;

use App\Guide;
use App\Project;
use App\Snippet;
use Tests\IntegrationTestCase;

class CommentCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_post_a_snippet_comment()
    {
        $this->signInAdmin();

        $snippet = create(Snippet::class);

        $this->post(route('snippet.comment.store', ['snippet' => $snippet->id]), [
            'comment' => 'My comment'
        ])
            ->assertRedirect(route('snippet.show', ['snippet' => $snippet->id]))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('comments', [
            'comment' => 'My comment',
            'commentable_id' => $snippet->id,
            'commentable_type' => 'App\Snippet'
        ]);
    }

    /** @test */
    public function an_authorized_user_can_post_a_guide_comment()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->post(route('guide.comment.store', ['guide' => $guide->id]), [
            'comment' => 'My comment'
        ])
            ->assertRedirect(route('guide.show', ['guide' => $guide->id]))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('comments', [
            'comment' => 'My comment',
            'commentable_id' => $guide->id,
            'commentable_type' => 'App\Guide'
        ]);
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
    public function an_unauthenticated_user_cannot_post_a_comment()
    {
        $project = create(Project::class);

        $this->post(route('project.comment.store', ['project' => $project->id]), [
            'comment' => 'My comment'
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_post_a_comment()
    {
        $this->signInRestricted();

        $project = create(Project::class);

        $this->post(route('project.comment.store', ['project' => $project->id]), [
            'comment' => 'My comment'
        ])->assertStatus(403);
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