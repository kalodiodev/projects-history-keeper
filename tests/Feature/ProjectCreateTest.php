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

        $project = factory(\App\Project::class)->make();

        $this->post(route('project.store'), $project->toArray())
            ->assertRedirect(route('project.index'));

        $this->assertDatabaseHas('projects', [
            'title'       => $project->title,
            'description' => $project->description
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_project()
    {
        $project = factory(\App\Project::class)->make();

        $this->post(route('project.store'), $project->toArray())
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('projects', [
            'title'       => $project->title,
            'description' => $project->description
        ]);
    }

    /** @test */
    public function project_requires_a_title()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->make(['title' => '']);

        $this->post(route('project.store'), $project->toArray())
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function project_title_length_should_within_the_right_limits()
    {
        $this->signIn();

        $project = factory(\App\Project::class)->make(['title' => 'ab']);
        $this->post(route('project.store'), $project->toArray())
            ->assertSessionHasErrors(['title']);

        $project = factory(\App\Project::class)->make(['title' => str_random(192)]);
        $this->post(route('project.store'), $project->toArray())
            ->assertSessionHasErrors(['title']);
    }
}
