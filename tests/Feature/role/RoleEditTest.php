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
    
    /** @test */
    public function a_user_can_update_role()
    {
        $this->signInAdmin();

        $role = create(Role::class);
        
        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData())
            ->assertRedirect(route('role.index'));
        
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => $this->updateData()['name']
        ]);
        
        $this->assertEquals(1, $role->permissions->count());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_role()
    {
        $role = create(Role::class);

        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData())
            ->assertRedirect(route('login'));
    }

    protected function updateData($overrides = [])
    {
        return array_merge([
            'name' => 'New Name',
            'permissions' => [
                '3'
            ]
        ], $overrides);
    }
}
