<?php

namespace Tests\Unit;

use App\Guide;
use Tests\TestCase;
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
    public function a_guide_belongs_to_tags()
    {
        $guide = make(Guide::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $guide->tags
        );
    }

    /** @test */
    public function when_creating_a_guide_a_slug_is_created()
    {
        $guide = create(Guide::class, ['title' => 'My guide title']);

        $this->assertEquals('my-guide-title', $guide->slug);
    }
}
