<?php

namespace Tests\Feature;

use App\Tag;
use Tests\IntegrationTestCase;

class TagEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_tag_edit()
    {
        $this->signInAdmin();

        $tag = create(Tag::class);

        $this->get(route('tag.edit', ['tag' => $tag->id]))
            ->assertStatus(200)
            ->assertViewIs('tag.edit')
            ->assertViewHas('tag', $tag->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_tag_edit()
    {
        $this->signInDefault();

        $tag = create(Tag::class);

        $this->get(route('tag.edit', ['tag' => $tag->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_tag_edit()
    {
        $tag = create(Tag::class);

        $this->get(route('tag.edit', ['tag' => $tag->id]))
            ->assertRedirect(route('login'));
    }
}
