<?php

namespace Tests\Feature;

use App\Guide;
use Tests\IntegrationTestCase;

class GuideEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_own_guide_edit()
    {
        $user = $this->signInDefault();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->get(route('guide.edit', ['guide' => $guide->id]))
            ->assertStatus(200)
            ->assertViewIs('guide.edit')
            ->assertViewHas('guide');
    }

    /** @test */
    public function a_user_cannot_view_other_users_guide_edit()
    {
        $this->signInDefault();

        $guide = create(Guide::class);

        $this->get(route('guide.edit', ['guide' => $guide->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_any_guide_edit()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->get(route('guide.edit', ['guide' => $guide->id]))
            ->assertStatus(200)
            ->assertViewIs('guide.edit')
            ->assertViewHas('guide');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_any_guide_edit()
    {
        $user = $this->signInRestricted();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->get(route('guide.edit', ['guide' => $guide->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_guide_edit()
    {
        $guide = create(Guide::class);

        $this->get(route('guide.edit', ['guide' => $guide->id]))
            ->assertRedirect(route('login'));
    }
}
