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

        $this->editTag($tag = create(Tag::class))
            ->assertStatus(200)
            ->assertViewIs('tag.edit')
            ->assertViewHas('tag', $tag->fresh());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_tag_edit()
    {
        $this->signInDefault();

        $this->editTag()->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_tag_edit()
    {
        $this->editTag()->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_update_a_tag()
    {
        $this->signInAdmin();

        $this->updateTag($tag = create(Tag::class), $newData = ['name' => 'New Name'])
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseHas('tags', array_merge([
            'id' => $tag->id,
        ], $newData));
    }

    /** @test */
    public function an_unauthorized_user_cannot_update_a_tag()
    {
        $this->signInDefault();

        $this->updateTag($tag = create(Tag::class))
            ->assertStatus(403);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_tag()
    {
        $this->updateTag($tag = create(Tag::class))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /** @test */
    public function a_tag_requires_a_name()
    {
        $this->signInAdmin();

        $this->updateTag($tag = create(Tag::class), ['name' => ''])
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }
    
    /** @test */
    public function tag_name_cannot_exceed_twenty_characters()
    {
        $this->signInAdmin();

        $this->updateTag($tag = create(Tag::class), ['name' => str_random(21)])
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /** @test */
    public function tag_name_should_be_unique()
    {
        $this->signInAdmin();

        create(Tag::class, $tagFields = ['name' => 'Test']);

        $this->updateTag($tag = create(Tag::class), $tagFields)
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('tags', $tag->toArray());
    }
    
    /** @test */
    public function tag_can_be_updated_with_name_left_unchanged()
    {
        $this->signInAdmin();

        $tagFields = ['name' => 'Test'];

        $this->updateTag(create(Tag::class, $tagFields), $tagFields)
            ->assertSessionHasNoErrors();
    }

    /**
     * Edit Tag
     *
     * @param Tag $stored_tag
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function editTag(Tag $stored_tag = null)
    {
        if($stored_tag == null) {
            $stored_tag = create(Tag::class);
        }

        return $this->get(route('tag.edit', ['tag' => $stored_tag->id]));
    }

    /**
     * Update provided Tag
     * If no Tag is provided then a tag will be created
     *
     * @param Tag $stored_tag
     * @param array $update_fields_overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function updateTag(Tag $stored_tag = null, $update_fields_overrides = [])
    {
        if($stored_tag == null) {
            $stored_tag = create(Tag::class);
        }

        $newData = array_merge([
            'name' => 'New Name'
        ], $update_fields_overrides);

        return $this->patch(route('tag.update', ['tag' => $stored_tag->id]), $newData);
    }
}
