<?php

namespace Tests\Unit;

use App\Project;
use App\Tag;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_has_a_creator()
    {
        $project = make(Project::class);

        $this->assertInstanceOf('App\User', $project->creator);
    }

    /** @test */
    public function a_project_has_tasks()
    {
        $project = make(Project::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $project->tasks
        );
    }

    /** @test */
    public function a_project_belongs_to_tags()
    {
        $project = make(Project::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $project->tags
        );
    }

    /** @test */
    public function deleting_a_project_should_also_detach_attached_tags()
    {
        $tag = create(Tag::class);
        $project = create(Project::class);

        $project->tags()->attach($tag);

        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $project->id,
            'taggable_type' => Project::class
        ]);

        $project->delete();

        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $project->id,
            'taggable_type' => Project::class
        ]);
    }

    /** @test */
    public function it_determines_whether_project_has_given_tag()
    {
        $tag = create(Tag::class);
        $project = create(Project::class);

        $project->tags()->attach($tag);

        $this->assertTrue($project->hasTag($tag));
        $this->assertFalse($project->hasTag(100));
    }

    /** @test */
    public function deleting_a_project_should_also_delete_its_tasks()
    {
        $project = create(Project::class);
        create(Task::class, ['project_id' => $project->id], 2);

        $project->delete();

        $this->assertDatabaseMissing('tasks', [
            'project_id' => $project->id
        ]);
    }
}
