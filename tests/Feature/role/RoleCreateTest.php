<?php

namespace Tests\Feature\role;

use Tests\IntegrationTestCase;

class RoleCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_create_role_page()
    {
        $this->signInAdmin();

        $this->get(route('role.create'))
            ->assertStatus(200)
            ->assertViewIs('role.create');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_create_role_page()
    {
        $this->get(route('role.create'))
            ->assertRedirect(route('login'));
    }
}
