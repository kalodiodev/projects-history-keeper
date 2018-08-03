<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class ProjectIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authenticated_user_can_view_projects_index()
    {
        $this->signIn();

        $this->get(route('project.index'))
            ->assertStatus(200)
            ->assertViewIs('project.index')
            ->assertViewHas(['projects']);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_projects_index()
    {
        $this->get(route('project.index'))
            ->assertRedirect(route('login'));
    }
}
