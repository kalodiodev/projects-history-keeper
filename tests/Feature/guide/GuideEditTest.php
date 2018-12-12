<?php

namespace Tests\Feature;

use App\Tag;
use App\Guide;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
            ->assertRedirect(route('guide.index'))
            ->assertSessionHas('message');

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
            ->assertRedirect(route('guide.index'))
            ->assertSessionHas('message');

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
    public function featured_image_remains_unchanged_when_no_new_image_is_provided()
    {
        $this->signInAdmin();
        $image_path = 'images/guide/featured.png';

        Storage::fake('testfs');
        UploadedFile::fake()->image('/guide/featured.png', 300, 300)
            ->storeAs('images/guide/','featured.png');

        $guide = create(Guide::class, ['featured_image' => '/' . $image_path]);

        $this->patch(route('guide.update', ['guide' => $guide->id]), $this->guideValidFields());

        $this->assertDatabaseHas('guides', [
            'id' => $guide->id,
            'featured_image' => '/' . $image_path
        ]);
        Storage::disk('testfs')->assertExists($image_path);
    }

    /** @test */
    public function an_authorized_user_can_update_guide_with_clear_featured_image()
    {
        $this->signInAdmin();
        
        Storage::fake('testfs');
        UploadedFile::fake()->image('/guide/featured.png', 300, 300)
            ->storeAs('images/guide/','featured.png');

        $guide = create(Guide::class, ['featured_image' => '/images/guide/featured.png']);

        $this->patch(route('guide.update', ['guide' => $guide->id]),
            $this->guideValidFields(['clear_featured_image' => 'on']));

        Storage::disk('testfs')->assertMissing('images/guide/featured.png');
    }

    /** @test */
    public function updating_a_featured_image_deletes_the_old_one()
    {
        $this->signInAdmin();

        Storage::fake('testfs');
        UploadedFile::fake()->image('/guide/featured.png', 300, 300)
            ->storeAs('images/guide/', 'featured.png');

        $guide = create(Guide::class, ['featured_image' => '/images/guide/featured.png']);

        $newImage = UploadedFile::fake()->image('/guide/newFeatured.png', 300, 300);

        $this->patch(route('guide.update', ['guide' => $guide->id]), 
            $this->guideValidFields(['featured_image' => $newImage]));

        Storage::disk('testfs')->assertMissing('images/guide/featured.png');
    }

    /** @test */
    public function featured_image_should_be_validated()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        Storage::fake('testfs');
        $image = UploadedFile::fake()->image('/guide/featured.png', 300, 300);

        $this->patch(route('guide.update', ['guide' => $guide->id]),
            $this->guideValidFields(['featured_image' => $image]))
            ->assertStatus(302);

        $image = UploadedFile::fake()->image('/guide/featured.bmp', 300, 300);

        $this->patch(route('guide.update', ['guide' => $guide->id]),
            $this->guideValidFields(['featured_image' => $image]))
            ->assertSessionHasErrors(['featured_image']);
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
