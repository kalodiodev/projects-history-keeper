<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class ProjectEditTest extends IntegrationTestCase
{
    /** @test */
    public function a_project_can_be_edited_by_its_creator()
    {
        $user = $this->signInDefault();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.edit')
            ->assertViewHas('project');
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit_others_projects()
    {
        $this->signInDefault();

        $project = create(Project::class);

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_edit_any_project()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.edit')
            ->assertViewHas('project');
    }

    /** @test */
    public function an_unauthorized_user_cannot_edit_own_project()
    {
        $user = $this->signInRestricted();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_a_project()
    {
        $project = factory(Project::class)->create();

        $this->get(route('project.edit', ['project' => $project->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_project_can_be_updated_by_its_creator()
    {
        $user = $this->signInDefault();

        $project = create(Project::class, ['user_id' => $user]);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertRedirect(route('project.show', ['project' => $project['id']]));

        $this->assertDatabaseHas('projects', array_merge([
            'id' => $project->id
        ], $this->projectData()));
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_update_others_projects()
    {
        $this->signInDefault();

        $project = create(Project::class);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_authorized_user_can_update_any_project()
    {
        $this->signInAdmin();
        
        $project = create(Project::class);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertRedirect(route('project.show', ['project' => $project['id']]));

        $this->assertDatabaseHas('projects', array_merge([
            'id' => $project->id
        ], $this->projectData()));
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_update_own_project()
    {
        $user = $this->signInRestricted();

        $project = create(Project::class, ['user_id' => $user]);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_project()
    {
        $project = create(Project::class);

        $this->patch(route('project.update', ['project' => $project->id]), $this->projectData())
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('projects', $project->toArray());
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
