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
    public function avatar_dimensions_should_be_whithin_limits_allowed()
    {
        $this->signInDefault();

        // Update Avatar
        $this->patch(route('avatar.update'), ['avatar' => $this->fake_image_file('image.png', 400, 400)])
            ->assertSessionHasErrors('avatar');

        $this->patch(route('avatar.update'), ['avatar' => $this->fake_image_file('image.png', 50, 50)])
            ->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function a_user_can_remove_avatar()
    {
        UploadedFile::fake()->image('image.png')->storeAs('images/avatars','image.png');

        $user = $this->signInDefault(['avatar' => 'avatars/image.png']);

        $this->delete(route('avatar.destroy'))
            ->assertRedirect(route('profile.edit'));

        Storage::disk('testfs')->assertMissing('images/avatars/image.png');
        $this->assertNull($user->avatar);
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
     * @param int $width
     * @param int $height
     * @return \Illuminate\Http\Testing\File
     */
    protected function fake_image_file($filename, $width = 250, $height = 250)
    {
        return UploadedFile::fake()->image($filename, $width, $height);
    }

}
