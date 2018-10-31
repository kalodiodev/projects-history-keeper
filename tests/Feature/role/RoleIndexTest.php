<?php

namespace Tests\Feature\role;

use Tests\IntegrationTestCase;

class RoleIndexTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_roles_index()
    {
        $this->signInAdmin();

        $this->get(route('role.index'))
            ->assertStatus(200)
            ->assertViewIs('role.index');
    }

    /** @test */
    public function an_authenticated_user_cannot_view_roles_index()
    {
        $this->get(route('role.index'))
            ->assertRedirect(route('login'));
    }
}
