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

    /** @test */
    public function an_unauthorized_user_cannot_upload_image_to_other_users_guide()
    {
        $this->signInDefault();

        $guide = create(Guide::class);

        $this->post(route('guide.image.store', ['guide' => $guide->id]), ['image' => $this->image])
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_upload_image_to_any_guide()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->post(route('guide.image.store', ['guide' => $guide->id]), ['image' => $this->image])
            ->assertRedirect(route('guide.show', ['guide' => $guide->id]))
            ->assertSessionHas('message');

        $this->assertEquals(1, Image::all()->count());
    }

    /** @test */
    public function an_image_should_be_of_type_jpg_or_png()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $bmp_file = UploadedFile::fake()->image('image.bmp', 300, 300);
        $this->post(route('guide.image.store', ['guide' => $guide->id]), ['image' => $bmp_file])
            ->assertSessionHasErrors(['image']);

        $jpeg_file = UploadedFile::fake()->image('image.jpg', 300, 300);
        $this->post(route('guide.image.store', ['guide' => $guide->id]), ['image' => $jpeg_file])
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function an_authorized_user_can_view_guide_featured_image()
    {
        $this->signInAdmin();

        UploadedFile::fake()->image('/guide/featured.png', 300, 300)
            ->storeAs('images/guide/','featured.png');
        
        create(Guide::class, ['featured_image' => '/images/guide/featured.png']);
        
        $response = $this->get(route('guide.image.featured', ['image' => 'featured.png']))
            ->assertStatus(200);

        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_guide_featured_image()
    {
        $this->get(route('guide.image.featured', ['image' => 'featured.png']))
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_view_guide_featured_image()
    {
        $this->signInRestricted();

        UploadedFile::fake()->image('/guide/featured.png', 300, 300)
            ->storeAs('images/guide/','featured.png');

        create(Guide::class, ['featured_image' => '/images/guide/featured.png']);
        
        $this->get(route('guide.image.featured', ['image' => 'featured.png']))
            ->assertStatus(403);
    }
}
