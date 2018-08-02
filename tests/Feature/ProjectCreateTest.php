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
}
