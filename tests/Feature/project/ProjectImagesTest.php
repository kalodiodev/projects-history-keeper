<?php

namespace Tests\Feature;

use App\Image;
use App\Project;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectImagesTest extends IntegrationTestCase
{
    protected $image;
    
    public function setUp()
    {
        parent::setUp();

        $this->image = UploadedFile::fake()->image('image.png', 300, 300);
        Storage::fake('testfs');
    }

    /** @test */
    public function a_user_can_upload_a_project_image()
    {
        $user = $this->signInDefault();
        $project = create(Project::class, ['user_id' => $user->id]);

        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $this->image])
            ->assertRedirect(route('project.show', ['project' => $project->id]))
            ->assertSessionHas('message');

        $this->assertEquals(1, Image::all()->count());
        Storage::disk('testfs')->assertExists('images/' . Image::first()->url);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_upload_a_project_image()
    {
        $project = create(Project::class);

        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $this->image])
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_upload_image_to_other_users_project()
    {
        $this->signInDefault();

        $project = create(Project::class);

        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $this->image])
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_upload_image_to_any_project()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $this->image])
            ->assertRedirect(route('project.show', ['project' => $project->id]))
            ->assertSessionHas('message');

        $this->assertEquals(1, Image::all()->count());
    }
}