<?php

namespace Tests\Feature;

use App\Tag;
use Tests\IntegrationTestCase;

class TagIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_tags_index()
    {
        $this->signInAdmin();

        create(Tag::class, [], 3);

        $response = $this->get(route('tag.index'))
            ->assertStatus(200)
            ->assertViewIs('tag.index');

        $tags = $response->original->getData()['tags'];
        $this->assertEquals(3, $tags->count());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_tags_index()
    {
        $this->signInDefault();

        $this->get(route('tag.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_tags_index()
    {
        $this->get(route('tag.index'))
            ->assertRedirect(route('login'));
    }
}