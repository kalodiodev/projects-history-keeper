<?php

namespace Tests\Feature;

use App\Tag;
use Tests\IntegrationTestCase;

class TagDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_delete_a_tag()
    {
        $this->signInAdmin();

        $tag = create(Tag::class);

        $this->delete(route('tag.destroy', ['tag' => $tag->id]))
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_tag()
    {
        $this->signInDefault();

        $tag = create(Tag::class);

        $this->delete(route('tag.destroy', ['tag' => $tag->id]))
            ->assertStatus(403);

        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_tag()
    {
        $tag = create(Tag::class);

        $this->delete(route('tag.destroy', ['tag' => $tag->id]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }
}
