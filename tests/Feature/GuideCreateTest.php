<?php

namespace Tests\Feature;

use App\Guide;
use Tests\IntegrationTestCase;

class GuideCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_guide_create()
    {
        $this->signInAdmin();

        $this->get(route('guide.create'))
            ->assertStatus(200)
            ->assertViewIs('guide.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_guide_create()
    {
        $this->signInRestricted();

        $this->get(route('guide.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_guide_create()
    {
        $this->get(route('guide.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_store_a_guide()
    {
        $this->signInDefault();

        $this->post(route('guide.store'), $this->guideValidFields())
            ->assertRedirect(route('guide.index'));

        $this->assertDatabaseHas('guides', $this->guideValidFields());
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_guide()
    {
        $this->signInRestricted();

        $this->post(route('guide.store'), $this->guideValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_guide()
    {
        $this->post(route('guide.store'), $this->guideValidFields())
            ->assertRedirect(route('login'));
    }

    /**
     * Get valid guide fields data
     *
     * @param array $overrides
     * @return array
     */
    protected function guideValidFields($overrides = [])
    {
        return array_merge([
            'title'       => 'My Title',
            'description' => 'My description',
            'body'        => 'This is the body of guide',
        ], $overrides);
    }
}
