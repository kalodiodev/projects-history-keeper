<?php

namespace Tests\Unit;

use App\Guide;
use App\Tag;
use App\User;
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
    public function when_creating_a_guide_a_slug_is_created()
    {
        $guide = create(Guide::class, ['title' => 'My guide title']);

        $this->assertEquals('my-guide-title', $guide->slug);
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
}
