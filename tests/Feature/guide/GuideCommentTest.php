<?php

namespace Tests\Feature;

use App\Guide;
use Tests\IntegrationTestCase;

class GuideCommentTest extends IntegrationTestCase
{
    /** @test */
    public function guide_view_contains_guide_comments()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->get(route('guide.show', ['guide' => $guide->id]))
            ->assertStatus(200)
            ->assertViewHas(['guide', 'comments']);
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
    public function an_unauthenticated_user_cannot_post_a_guide_comment()
    {
        $guide = create(Guide::class);

        $this->post(route('guide.comment.store', ['guide' => $guide->id]), [
            'comment' => 'My comment'
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_post_a_guide_comment()
    {
        $this->signInRestricted();

        $guide = create(Guide::class);

        $this->post(route('guide.comment.store', ['guide' => $guide->id]), [
            'comment' => 'My comment'
        ])->assertStatus(403);
    }

    /** @test */
    public function a_comment_requires_a_comment_body()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->post(route('guide.comment.store', ['guide' => $guide->id]), [
                'comment' => ''
            ])
            ->assertSessionHasErrors(['comment']);
    }
}