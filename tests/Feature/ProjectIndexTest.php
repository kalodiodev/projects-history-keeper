<?php

namespace Tests\Feature;

use App\Project;
use Tests\IntegrationTestCase;

class ProjectIndexTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_own_projects_index()
    {
        $user = $this->signInDefault();
        create(Project::class, ['user_id' => $user->id], 2);
        create(Project::class, [], 2);

        $responses = $this->get(route('project.index'))
            ->assertStatus(200)
            ->assertViewIs('project.index')
            ->assertViewHas(['projects']);

        $projects = $responses->original->getData()['projects'];
        $this->assertEquals(2, $projects->count());
    }

    /** @test */
    public function an_authorized_user_can_view_all_projects_index()
    {
        $user = $this->signInAdmin();
        create(Project::class, ['user_id' => $user->id], 2);
        create(Project::class, [], 2);

        $responses = $this->get(route('project.index'))
            ->assertStatus(200)
            ->assertViewIs('project.index')
            ->assertViewHas(['projects']);

        $projects = $responses->original->getData()['projects'];
        $this->assertEquals(4, $projects->count());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_projects_index()
    {
        $this->get(route('project.index'))
            ->assertRedirect(route('login'));
    }
}
