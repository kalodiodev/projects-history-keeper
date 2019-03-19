<?php

namespace Tests\Feature\image;

use App\Image;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageDeleteTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('testfs');
    }

    /** @test */
    public function an_authorized_user_can_delete_an_image()
    {
        $this->signInAdmin();

        UploadedFile::fake()->image('image.png', 300, 300)->storeAs('images/','image.png');
        create(Image::class, ['file' => 'image.png', 'path' => 'images/']);

        Storage::disk('testfs')->assertExists('images/image.png');

        $this->delete(route('image.destroy', ['image' => 'image.png']))
            ->assertStatus(302);

        Storage::disk('testfs')->assertMissing('images/image.png');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_an_image()
    {
        UploadedFile::fake()->image('image.png', 300, 300)->storeAs('images/','image.png');
        create(Image::class, ['file' => 'image.png', 'path' => 'images/']);

        Storage::disk('testfs')->assertExists('images/image.png');

        $this->delete(route('image.destroy', ['image' => 'image.png']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_an_image()
    {
        $this->signInRestricted();

        UploadedFile::fake()->image('image.png', 300, 300)->storeAs('images/','image.png');
        create(Image::class, ['file' => 'image.png', 'path' => 'images/']);

        Storage::disk('testfs')->assertExists('images/image.png');

        $this->delete(route('image.destroy', ['image' => 'image.png']))
            ->assertStatus(403);
    }
}
