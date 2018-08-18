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

    /** @test */
    public function an_authorized_user_can_update_a_tag()
    {
        $this->signInAdmin();

        $tag = create(Tag::class);
        $newData = ['name' => 'New name'];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseHas('tags', array_merge([
            'id' => $tag->id,
        ], $newData));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_a_tag()
    {
        $this->signInDefault();

        $tag = create(Tag::class);
        $newData = ['name' => 'New name'];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertStatus(403);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_tag()
    {
        $tag = create(Tag::class);
        $newData = ['name' => 'New name'];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /** @test */
    public function a_tag_requires_a_name()
    {
        $this->signInAdmin();
        
        $tag = create(Tag::class);
        $newData = ['name' => ''];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }
    
    /** @test */
    public function tag_name_cannot_exceed_twenty_characters()
    {
        $this->signInAdmin();

        $tag = create(Tag::class);
        $newData = ['name' => str_random(21)];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /** @test */
    public function tag_name_should_be_unique()
    {
        $this->signInAdmin();

        $tag = create(Tag::class);
        create(Tag::class, ['name' => 'Test']);

        $newData = ['name' => 'Test'];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }
    
    /** @test */
    public function tag_can_be_updated_with_name_left_unchanged()
    {
        $this->signInAdmin();

        $tag = create(Tag::class, ['name' => 'Test']);
        $newData = ['name' => 'Test'];

        $this->patch(route('tag.update', ['tag' => $tag->id]), $newData)
            ->assertSessionHasNoErrors();
    }
}
