<?php

namespace Tests\Feature\guide;

use App\Guide;
use App\Image;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GuideImagesTest extends IntegrationTestCase
{
    protected $image;
    
    public function setUp()
    {
        parent::setUp();

        $this->image = UploadedFile::fake()->image('image.png', 300, 300);
        Storage::fake('testfs');
    }
    
    /** @test */
    public function a_user_can_upload_a_guide_image()
    {
        $user = $this->signInDefault();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->post(route('guide.image.store', ['guide' => $guide->id]), ['image' => $this->image])
            ->assertRedirect(route('guide.show', ['guide' => $guide->id]))
            ->assertSessionHas('message');

        $this->assertEquals(1, Image::all()->count());
        Storage::disk('testfs')->assertExists(Image::first()->fullpath());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_upload_a_guide_image()
    {
        $guide = create(Guide::class);

        $this->post(route('guide.image.store', ['guide' => $guide->id]), ['image' => $this->image])
            ->assertRedirect(route('login'));
    }
}
