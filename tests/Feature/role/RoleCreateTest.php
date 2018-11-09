<?php

namespace Tests\Feature\role;

use App\Role;
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
    
    /** @test */
    public function a_user_can_store_a_role()
    {
        $this->signInAdmin();
        
        $role = make(Role::class);
        
        $data = array_merge($role->toArray(), [
            'permissions' => ['3']
        ]);
        
        $this->post(route('role.store'), $data)
            ->assertRedirect(route('role.index'));
        
        $fresh = Role::where('name', $role->name)->firstOrFail();
        
        $this->assertDatabaseHas('roles', [
            'name' => $role->name
        ]);
        
        $this->assertEquals(1, $fresh->permissions->count());
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_store_a_role()
    {
        $role = make(Role::class);
        
        $this->post(route('role.store'), $role->toArray())
            ->assertRedirect(route('login'));
    }
}
