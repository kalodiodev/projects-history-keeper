<?php

namespace Tests\Feature;

use App\Guide;
use App\Tag;
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

    /** @test */
    public function an_authorized_user_can_update_own_guide()
    {
        $user = $this->signInDefault();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->patch(route('guide.update', ['guide' => $guide->id]), $this->guideValidFields())
            ->assertRedirect(route('guide.index'));

        $this->assertDatabaseHas('guides', array_merge([
            'id' => $user->id,
        ], $this->guideValidFields()));
    }

    /** @test */
    public function a_user_cannot_update_other_users_guide()
    {
        $this->signInDefault();

        $guide = create(Guide::class);

        $this->patch(route('guide.update', ['guide' => $guide->id]), $this->guideValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_update_any_guide()
    {
        $user = $this->signInAdmin();

        $guide = create(Guide::class);

        $this->patch(route('guide.update', ['guide' => $guide->id]), $this->guideValidFields())
            ->assertRedirect(route('guide.index'));

        $this->assertDatabaseHas('guides', array_merge([
            'id' => $user->id,
        ], $this->guideValidFields()));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_any_guide()
    {
        $user = $this->signInRestricted();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->patch(route('guide.update', ['guide' => $guide->id]), $this->guideValidFields())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_guide()
    {
        $guide = create(Guide::class);

        $this->patch(route('guide.update', ['guide' => $guide->id]), $this->guideValidFields())
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function tags_can_be_synced_to_guide()
    {
        $this->signInAdmin();

        // Stored Guide
        $guide = create(Guide::class);
        $tag = create(Tag::class);

        $guide->tags()->attach($tag);

        // Tags to sync guide
        $tags = create(Tag::class, [], 3);

        // Update guide
        $this->patch(route('guide.update', [
            'guide' => $guide->id
        ]), $this->guideValidFields(['tags' => $tags]));

        $this->assertEquals(3, $guide->fresh()->tags->count());
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
