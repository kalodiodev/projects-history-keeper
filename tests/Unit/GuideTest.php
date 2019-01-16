<?php

namespace Tests\Unit;

use App\Image;
use App\Tag;
use App\User;
use App\Guide;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuideTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guide_has_a_creator()
    {
        $guide = make(Guide::class);

        $this->assertInstanceOf('App\User', $guide->creator);
    }
    
    /** @test */
    public function it_should_return_a_soft_deleted_creator()
    {
        $user = create(User::class);
        $guide = create(Guide::class, ['user_id' => $user->id]);
        $user->delete();
        
        $this->assertInstanceOf('App\User', $guide->fresh()->creator);
    }

    /** @test */
    public function a_guide_belongs_to_tags()
    {
        $guide = make(Guide::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $guide->tags
        );
    }

    /** @test */
    public function a_guide_has_many_comments()
    {
        $guide = make(Guide::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $guide->comments
        );
    }

    /** @test */
    public function it_determines_whether_guide_has_given_tag()
    {
        $tag = create(Tag::class);
        $guide = create(Guide::class);

        $guide->tags()->attach($tag);

        $this->assertTrue($guide->hasTag($tag));
        $this->assertFalse($guide->hasTag(100));
    }
    
    /** @test */
    public function it_determines_whether_guide_has_featured_image()
    {
        $guide = make(Guide::class);
        $this->assertFalse($guide->hasFeaturedImage());
        
        $guide = make(Guide::class, ['featured_image' => 'myimage.png']);
        $this->assertTrue($guide->hasFeaturedImage());
    }
    
    /** @test */
    public function deleting_a_guide_should_also_delete_its_featured_image()
    {
        Storage::fake('testfs');
        
        $featured = UploadedFile::fake()->image('featured.png', 300, 300)->storeAs('images/guide','featured.png');
        $guide = create(Guide::class, ['featured_image' => $featured]);
        
        Storage::disk('testfs')->assertExists($guide->featured_image);

        $guide->delete();

        Storage::disk('testfs')->assertMissing($guide->featured_image);
    }

    /** @test */
    public function deleting_a_guide_should_also_delete_its_images()
    {
        $guide = create(Guide::class);
        $image = create(Image::class, [
            'imageable_type' => Guide::class,
            'imageable_id' => $guide->id
        ]);

        $guide->delete();

        $this->assertDatabaseMissing('images', [
            'id' => $image->id
        ]);
    }
}
