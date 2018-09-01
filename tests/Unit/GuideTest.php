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
    public function a_project_belongs_to_tags()
    {
        $project = make(Guide::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $project->tags
        );
    }
}
