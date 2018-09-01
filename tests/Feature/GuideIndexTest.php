<?php

namespace Tests\Feature;

use App\Guide;
use Tests\IntegrationTestCase;

class GuideIndexTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_own_guides_index()
    {
        $this->signInDefault();

        $this->get(route('guide.index'))
            ->assertStatus(200)
            ->assertViewIs('guide.index')
            ->assertViewHas('guides');
    }

    /** @test */
    public function an_authorized_user_can_view_all_guides_index()
    {
        $user = $this->signInAdmin();
        create(Guide::class, ['user_id' => $user->id], 2);
        create(Guide::class, [], 2);

        $responses = $this->get(route('guide.index'))
            ->assertStatus(200)
            ->assertViewIs('guide.index')
            ->assertViewHas(['guides']);

        $guides = $responses->original->getData()['guides'];
        $this->assertEquals(4, $guides->count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_guides()
    {
        $this->signInRestricted();

        $this->get(route('guide.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_guides_index()
    {
        $this->get(route('guide.index'))
            ->assertRedirect(route('login'));
    }
}
