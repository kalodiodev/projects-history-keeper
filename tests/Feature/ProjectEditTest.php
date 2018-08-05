<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use Tests\IntegrationTestCase;

class ProjectEditTest extends IntegrationTestCase
{
    /** @test */
    public function a_project_can_be_edited_by_its_creator()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);

        $project = factory(Project::class)->create(['user_id' => $user->id]);

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.edit')
            ->assertViewHas('project');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_a_project()
    {
        $project = factory(Project::class)->create();

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenicated_user_can_update_a_project()
    {
        $this->signIn();

        $project = create(Project::class);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertRedirect(route('project.show', ['project' => $project['id']]));

        $this->assertDatabaseHas('projects', array_merge([
            'id' => $project->id
        ], $this->projectData()));
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_project()
    {
        $project = create(Project::class);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', [
            'id'          => $project->id,
            'title'       => $project->title,
            'description' => $project->description
        ]);
    }

    /** @test */
    public function project_requires_a_title()
    {
        $newData = $this->projectData(['title' => '']);

        $this->patchProject($newData)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function project_title_length_should_be_within_the_right_limits()
    {
        $newData = $this->projectData(['title' => str_random(2)]);

        $this->patchProject($newData)
            ->assertSessionHasErrors('title');

        $newData = $this->projectData(['title' => str_random(192)]);

        $this->patchProject($newData)
            ->assertSessionHasErrors('title');
    }

    /**
     * @param $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function patchProject($data)
    {
        $this->signIn();

        $project = create(Project::class);

        return $this->patch(route('project.update', ['project' => $project->id]), $data);
    }

    /**
     * @param array $overrides
     * @return array
     */
    protected function projectData($overrides = [])
    {
        return array_merge([
            'title'       => 'My title',
            'description' => 'My Description'
        ], $overrides);
    }
}
