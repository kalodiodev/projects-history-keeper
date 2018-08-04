<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class ProjectCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_create_a_project()
    {
        $this->signIn();

        $this->get(route('project.create'))
            ->assertStatus(200)
            ->assertViewIs('project.create');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_project()
    {
        $this->get(route('project.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_store_a_project()
    {
        $this->signIn();

        $project_data = [
            'title'       => 'My title',
            'description' => 'My description'
        ];

        $this->postProject($project_data)
            ->assertRedirect(route('project.index'));

        $this->assertDatabaseHas('projects', $project_data);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_project()
    {
        $project_data = [
            'title'       => 'My title',
            'description' => 'My description'
        ];

        $this->postProject($project_data)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('projects', $project_data);
    }

    /** @test */
    public function project_requires_a_title()
    {
        $this->signIn();

        $this->postProject(['title' => ''])
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function project_title_length_should_within_the_right_limits()
    {
        $this->signIn();

        $this->postProject(['title' => str_random(2)])
            ->assertSessionHasErrors(['title']);

        $this->postProject(['title' => str_random(192)])
            ->assertSessionHasErrors(['title']);
    }

    /**
     * Post a new project
     *
     * @param array $attributes
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function postProject($attributes = [])
    {
        $project = make(\App\Project::class, $attributes);

        return $this->post(route('project.store'), $project->toArray());
    }
}
