<?php

namespace Tests\Feature;

use App\Guide;
use Tests\IntegrationTestCase;

class GuideViewTest extends IntegrationTestCase
{
    /** @test */
    public function a_guide_can_be_viewed_by_its_creator()
    {
        $this->withoutExceptionHandling();
        $user = $this->signInDefault();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->get(route('guide.show', ['guide' => $guide->id]))
            ->assertStatus(200)
            ->assertViewIs('guide.show')
            ->assertViewHas('guide', $guide->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_other_creators_guides()
    {
        $this->signInDefault();

        $guide = create(Guide::class);

        $this->get(route('guide.show', ['guide' => $guide->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_any_guide()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->get(route('guide.show', ['guide' => $guide->id]))
            ->assertStatus(200)
            ->assertViewIs('guide.show')
            ->assertViewHas('guide', $guide->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_any_guide()
    {
        $this->signInRestricted();

        $guide = create(Guide::class);

        $this->get(route('guide.show', ['guide' => $guide->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_guide()
    {
        $guide = create(Guide::class);

        $this->get(route('guide.show', ['guide' => $guide->id]))
            ->assertRedirect(route('login'));
    }
}
