<?php

namespace Tests\Feature\image;

use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_view_avatar_image()
    {
        Storage::fake('testfs');
        UploadedFile::fake()->image('image.png')->storeAs('images/avatars','image.png');

        $this->signInDefault();

        $response = $this->get(route('avatar.show', ['avatar' => 'image.png']))
            ->assertStatus(200);

        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
    public function a_guest_user_cannot_view_avatar_image()
    {
        Storage::fake('testfs');
        UploadedFile::fake()->image('image.png')->storeAs('images/avatars','image.png');

        $this->get(route('avatar.show', ['avatar' => 'image.png']))
            ->assertRedirect(route('login'));
    }

}
