<?php

namespace Tests\Feature;

use App\Image;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageViewTest extends IntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();

        Storage::fake('testfs');
    }

    /** @test */
    public function an_authorized_user_can_view_image()
    {
        $this->signInAdmin();

        UploadedFile::fake()->image('image.png', 300, 300)->storeAs('images/','image.png');
        create(Image::class, ['file' => 'image.png', 'path' => 'images/']);

        $response = $this->get(route('image.show', ['image' => 'image.png']))
            ->assertStatus(200);

        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_image()
    {
        UploadedFile::fake()->image('image.png', 300, 300)->storeAs('images/','image.png');
        create(Image::class, ['file' => 'image.png', 'path' => 'images/']);

        $this->get(route('image.show', ['image' => 'image.png']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_image()
    {
        $this->signInRestricted();

        UploadedFile::fake()->image('image.png', 300, 300)->storeAs('images/','image.png');
        create(Image::class, ['file' => 'image.png', 'path' => 'images/']);

        $this->get(route('image.show', ['image' => 'image.png']))
            ->assertStatus(403);
    }
}