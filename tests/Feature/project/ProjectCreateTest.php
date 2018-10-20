<?php

namespace Tests\Feature;

use App\Project;
use App\Tag;
use Tests\IntegrationTestCase;

class ProjectCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_create_a_project()
    {
        $this->signInAdmin();

        $this->get(route('project.create'))
            ->assertStatus(200)
            ->assertViewIs('project.create')
            ->assertViewHas('tags');
    }

    /** @test */
    public function an_unauthorized_user_cannot_create_a_project()
    {
        $this->signInRestricted();

        $this->get(route('project.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_project()
    {
        $this->get(route('project.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authorized_user_can_store_a_project()
    {
        $this->signInAdmin();

        $this->postProject($this->validData())
            ->assertRedirect(route('project.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('projects', $this->validData());
    }

    /** @test */
    public function an_unauthorized_user_can_store_a_project()
    {
        $this->signInRestricted();

        $this->postProject($this->validData())
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_project()
    {
        $this->postProject($this->validData())
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('projects', $this->validData());
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

    /** @test */
    public function tags_can_be_attached_to_project()
    {
        $this->signInAdmin();

        $tags = create(Tag::class, [], 3);

        $this->postProject($this->validData(['tags' => $tags->pluck('id')->toArray()]));

        $project = Project::first();

        $this->assertEquals(3, $project->tags->count());
    }

    /**
     * Get project data
     *
     * @param array $overrides
     * @return array
     */
    protected function validData($overrides = [])
    {
        return array_merge([
            'title'       => 'My title',
            'description' => 'My description'
        ], $overrides);
    }

    /**
     * Post a new project
     *
     * @param array $attributes
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function postProject($attributes = [])
    {
        $project = make(Project::class, $attributes);

        return $this->post(route('project.store'), $project->toArray());
    }
}
