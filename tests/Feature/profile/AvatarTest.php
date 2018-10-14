<?php

namespace Tests\Feature\image;

use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarTest extends IntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();

        Storage::fake('testfs');
    }

    /** @test */
    public function an_authenticated_user_can_update_avatar()
    {
        $user = $this->signInDefault();

        $this->patch(route('avatar.update'), ['avatar' => $this->fake_image_file('image.png')])
            ->assertRedirect(route('profile.edit'));
  
        Storage::disk('testfs')->assertExists('images' . $user->avatar);
    }

    /** @test */
    public function updating_avatar_should_remove_old_avatar_file_from_storage()
    {
        $user = $this->signInDefault();

        // Update Avatar
        $this->patch(route('avatar.update'), ['avatar' => $this->fake_image_file('image.png')]);
        Storage::disk('testfs')->assertExists('images' . $user->avatar);

        // Update avatar with new image
        $old_avatar = $user->avatar;
        $this->patch(route('avatar.update'), ['avatar' => $this->fake_image_file('image2.png')]);

        // Old avatar file should be missing
        Storage::disk('testfs')->assertMissing('images' . $old_avatar);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_avatar()
    {
        $this->patch(route('avatar.update'), ['avatar' => $this->fake_image_file('image.png')])
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_view_avatar_image()
    {
        UploadedFile::fake()->image('image.png')->storeAs('images/avatars','image.png');
        
        $this->signInDefault();

        $response = $this->get(route('avatar.show', ['avatar' => 'image.png']))
            ->assertStatus(200);

        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
    public function a_guest_user_cannot_view_avatar_image()
    {
        UploadedFile::fake()->image('image.png')->storeAs('images/avatars','image.png');

        $this->get(route('avatar.show', ['avatar' => 'image.png']))
            ->assertRedirect(route('login'));
    }

    /**
     * Create fake image file
     *
     * @param $filename
     * @return \Illuminate\Http\Testing\File
     */
    protected function fake_image_file($filename)
    {
        return UploadedFile::fake()->image($filename);
    }

}
