<?php

namespace Tests\Unit;

use App\Image;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_image_may_belong_to_an_imageable()
    {
        $image = make(Image::class);

        $this->assertInstanceOf(Model::class, $image->imageable);
    }

    /** @test */
    public function deleting_an_image_also_deletes_image_file()
    {
        Storage::fake('testfs');

        UploadedFile::fake()->image('test.png', 300, 300)->storeAs('images','test.png');
        $image = create(Image::class, ['file' => 'test.png']);

        Storage::disk('testfs')->assertExists($image->fullpath());
        
        $image->delete();
        
        Storage::disk('testfs')->assertMissing($image->fullpath());
    }

}