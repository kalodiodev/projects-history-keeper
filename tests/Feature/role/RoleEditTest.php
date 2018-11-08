<?php

namespace Tests\Feature\role;

use App\Role;
use Tests\IntegrationTestCase;

class RoleEditTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_role_edit_page()
    {
        $this->signInAdmin();
        
        $role = create(Role::class);
        
        $this->get(route('role.edit', ['role' => $role->id]))
            ->assertStatus(200)
            ->assertViewIs('role.edit');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_role_edit_page()
    {
        $role = create(Role::class);

        $this->get(route('role.edit', ['role' => $role->id]))
            ->assertRedirect(route('login'));
    }
}
