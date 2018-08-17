<?php

namespace Tests\Unit;

use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_tag_belongs_to_many_projects()
    {
        $tag = make(Tag::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $tag->projects
        );
    }

}