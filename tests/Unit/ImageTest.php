<?php

namespace Tests\Unit;

use App\Image;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function an_image_may_belong_to_a_project()
    {
        $image = make(Image::class);

        $this->assertInstanceOf(Project::class, $image->imageable);
    }

}