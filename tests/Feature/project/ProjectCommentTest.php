<?php

namespace Tests\Feature;

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
}