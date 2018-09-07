<?php

namespace Tests\Unit;

use App\Guide;
use App\Snippet;
use App\Tag;
use App\Project;
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
    
    /** @test */
    public function deleting_a_tag_should_also_detach_attached_projects()
    {
        $tag = create(Tag::class);
        $project = create(Project::class);
        
        $tag->projects()->attach($project);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $project->id,
            'taggable_type' => Project::class
        ]);

        $tag->delete();

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $project->id,
            'taggable_type' => Project::class
        ]);
    }

    /** @test */
    public function a_tag_belongs_to_many_guides()
    {
        $tag = make(Tag::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $tag->guides
        );
    }

    /** @test */
    public function deleting_a_tag_should_also_detach_attached_guides()
    {
        $tag = create(Tag::class);
        $guide = create(Guide::class);

        $tag->guides()->attach($guide);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $guide->id,
            'taggable_type' => Guide::class
        ]);

        $tag->delete();

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $guide->id,
            'taggable_type' => Guide::class
        ]);
    }

    /** @test */
    public function a_tag_belongs_to_many_snippets()
    {
        $tag = make(Tag::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $tag->snippets
        );
    }

    /** @test */
    public function deleting_a_tag_should_also_detach_attached_snippets()
    {
        $tag = create(Tag::class);
        $snippet = create(Snippet::class);

        $tag->snippets()->attach($snippet);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $snippet->id,
            'taggable_type' => Snippet::class
        ]);

        $tag->delete();

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $snippet->id,
            'taggable_type' => Snippet::class
        ]);
    }
}