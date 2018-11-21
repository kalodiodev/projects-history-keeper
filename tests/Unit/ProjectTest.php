<?php

namespace Tests\Unit;

use App\Tag;
use App\Task;
use App\Image;
use App\Project;
use App\User;
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
    public function it_should_return_a_soft_deleted_creator()
    {
        $user = create(User::class);
        $project = create(Project::class, ['user_id' => $user->id]);
        $user->delete();

        $this->assertInstanceOf('App\User', $project->fresh()->creator);
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

    /** @test */
    public function a_project_may_have_many_images()
    {
        $project = make(Project::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $project->images
        );
    }

    /** @test */
    public function deleting_a_project_should_also_delete_its_images()
    {
        $project = create(Project::class);
        $image = create(Image::class, [
            'imageable_type' => Project::class, 
            'imageable_id' => $project->id
        ]);
        
        $project->delete();

        $this->assertDatabaseMissing('images', [
            'id' => $image->id
        ]);
    }
}
