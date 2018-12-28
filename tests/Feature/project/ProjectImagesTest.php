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

        Storage::fake('testfs');
        $this->image = UploadedFile::fake()->image('image.png', 300, 300);
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
        Storage::disk('testfs')->assertExists(Image::first()->fullpath());
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
    
    /** @test */
    public function an_image_should_be_of_type_jpg_or_png()
    {
        $this->signInAdmin();

        $project = create(Project::class);
        
        $bmp_file = UploadedFile::fake()->image('image.bmp', 300, 300);
        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $bmp_file])
            ->assertSessionHasErrors(['image']);
        
        $jpeg_file = UploadedFile::fake()->image('image.jpg', 300, 300);
        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $jpeg_file])
            ->assertSessionHasNoErrors();
    }
}