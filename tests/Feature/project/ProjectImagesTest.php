<?php

namespace Tests\Feature;

use App\Image;
use App\Project;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectImagesTest extends IntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();

        Storage::fake('testfs');
    }

    /** @test */
    public function a_user_can_upload_a_project_image()
    {
        $user = $this->signInDefault();
        $project = create(Project::class, ['user_id' => $user->id]);

        $image = UploadedFile::fake()->image('image.png', 300, 300);

        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $image])
            ->assertRedirect(route('project.show', ['project' => $project->id]))
            ->assertSessionHas('message');

        $this->assertEquals(1, Image::all()->count());
        Storage::disk('testfs')->assertExists(Image::first()->url);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_upload_a_project_image()
    {
        $project = create(Project::class);
        $image = UploadedFile::fake()->image('image.png', 300, 300);

        $this->post(route('project.image.store', ['project' => $project->id]), ['image' => $image])
            ->assertRedirect(route('login'));
    }
}