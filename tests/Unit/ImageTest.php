<?php

namespace Tests\Unit;

use App\Image;
use Tests\TestCase;
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

}