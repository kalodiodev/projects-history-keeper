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
}