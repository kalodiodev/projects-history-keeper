<?php

namespace Tests\Feature;

use App\Guide;
use App\Tag;
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

    /** @test */
    public function an_admin_can_index_all_guides_by_tag()
    {
        $this->signInAdmin();

        $firstTag = create(Tag::class);
        $secondTag = create(Tag::class);

        $this->createGuidesOfTag($firstTag, 4);
        $this->createGuidesOfTag($secondTag, 3);

        $responses = $this->get(route('guide.index', ['tag' => $firstTag->name]))
            ->assertStatus(200);

        $guides = $responses->original->getData()['guides'];
        $this->assertEquals(4, $guides->count());
    }

    /** @test */
    public function a_default_user_can_index_only_their_guides_by_tag()
    {
        $user = $this->signInDefault();

        $firstTag = create(Tag::class);
        $secondTag = create(Tag::class);

        $this->createGuidesOfTag($firstTag, 2);
        $this->createGuidesOfTag($secondTag, 3);

        // User's projects
        $this->createGuidesOfTag($firstTag, 1, ['user_id' => $user->id]);

        $responses = $this->get(route('guide.index', ['tag' => $firstTag->name]))
            ->assertStatus(200);

        $guides = $responses->original->getData()['guides'];
        $this->assertEquals(1, $guides->count());
    }

    /**
     * Create Guides with given tag
     *
     * @param $tag
     * @param $guidesNumber
     * @param array $overrides
     * @return mixed
     */
    private function createGuidesOfTag($tag, $guidesNumber, $overrides = [])
    {
        $guides = create(Guide::class, $overrides, $guidesNumber);
        foreach ($guides as $guide) {
            $guide->tags()->attach($tag);
        }

        return $guides;
    }
}
