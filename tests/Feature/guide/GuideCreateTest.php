<?php

namespace Tests\Feature;

use App\Guide;
use App\Tag;
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

    /** @test */
    public function it_validates_guide_title()
    {
        $this->signInDefault();

        $this->post(route('guide.store'), $this->guideValidFields(['title' => '']))
            ->assertSessionHasErrors(['title']);

        $this->post(route('guide.store'), $this->guideValidFields(['title' => '123']))
            ->assertSessionHasErrors(['title']);

        $this->post(route('guide.store'), $this->guideValidFields(['title' => str_random(91)]))
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function it_validates_guide_description()
    {
        $this->signInDefault();

        $this->post(route('guide.store'), $this->guideValidFields(['description' => str_random(5)]))
            ->assertSessionHasErrors(['description']);

        $this->post(route('guide.store'), $this->guideValidFields(['description' => str_random(192)]))
            ->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function tags_can_be_attached_to_guide()
    {
        $this->signInAdmin();

        $tags = create(Tag::class, [], 3);

        $this->post(route('guide.store'), $this->guideValidFields(['tags' => $tags->pluck('id')->toArray()]));

        $guide = Guide::first();

        $this->assertEquals(3, $guide->tags->count());
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
