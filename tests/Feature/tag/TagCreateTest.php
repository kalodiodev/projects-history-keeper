<?php

namespace Tests\Feature;

use App\Tag;
use Tests\IntegrationTestCase;

class TagCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_create_tag()
    {
        $this->signInAdmin();

        $this->get(route('tag.create'))
            ->assertStatus(200)
            ->assertViewIs('tag.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_create_tag()
    {
        $this->signInDefault();

        $this->get(route('tag.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_create_tag()
    {
        $this->get(route('tag.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_store_a_tag()
    {
        $this->signInAdmin();

        $tag = make(Tag::class);

        $this->post(route('tag.store'), $tag->toArray())
            ->assertRedirect(route('tag.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('tags', ['name' => $tag->name]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_tag()
    {
        $this->signInDefault();

        $tag = make(Tag::class);

        $this->post(route('tag.store'), $tag->toArray())
            ->assertStatus(403);

        $this->assertDatabaseMissing('tags', ['name' => $tag->name]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_tag()
    {
        $tag = make(Tag::class);

        $this->post(route('tag.store'), $tag->toArray())
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function tag_requires_a_name()
    {
        $this->signInAdmin();

        $this->post(route('tag.store'), ['name' => ''])
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function tag_name_cannot_exceed_twenty_characters()
    {
        $this->signInAdmin();

        $this->post(route('tag.store', ['name' => str_random(21)]))
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function tag_name_should_be_unique()
    {
        $this->signInAdmin();

        create(Tag::class, ['name' => 'Test']);

        $this->post(route('tag.store'), ['name' => 'Test'])
            ->assertSessionHasErrors(['name']);
    }
}