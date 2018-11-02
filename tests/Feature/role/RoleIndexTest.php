<?php

namespace Tests\Feature\role;

use Tests\IntegrationTestCase;

class RoleIndexTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_roles_index()
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
    
    /** @test */
    public function an_unauthorized_user_cannot_view_roles_index()
    {
        $this->signInRestricted();
        
        $this->get(route('role.index'))
            ->assertStatus(403);
    }
}
