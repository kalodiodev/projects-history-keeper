<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class ProjectViewTest extends IntegrationTestCase
{
    /** @test */
    public function a_project_can_be_viewed_by_its_creator()
    {
        $user = $this->signInDefault();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->get(route('project.show', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.show')
            ->assertViewHas('project', Project::where('id', $project->id)->with('creator')->first());
    }

    /** @test */
    public function an_authorized_user_can_view_any_project()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->get(route('project.show', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('project.show')
            ->assertViewHas('project', Project::where('id', $project->id)->with('creator')->first());
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_project()
    {
        $this->signInRestricted();

        $this->httpGetProjectShow()->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_a_project()
    {
        $this->httpGetProjectShow()->assertRedirect(route('login'));
    }
    
    /**
     * Http GET Project
     *
     * @param array $project_overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function httpGetProjectShow($project_overrides = [])
    {
        $project = create(Project::class, $project_overrides);

        return $this->get(route('project.show', ['project' => $project->id]));
    }
}
