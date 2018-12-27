<?php

namespace Tests\Feature\role;

use App\Permission;
use App\Role;
use Tests\IntegrationTestCase;

class RoleCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_create_role_page()
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

        $role_name = 'TestRole';
        $permissions = [Permission::first()->id];

        $this->post_role(['name' => $role_name], $permissions)
            ->assertRedirect(route('role.index'))
            ->assertSessionHas('message');
        
        $this->assertDatabaseHas('roles', [
            'name' => $role_name
        ]);

        $role = Role::where('name', $role_name)->firstOrFail();
        $this->assertEquals(1, $role->permissions->count());
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_store_a_role()
    {
        $role = make(Role::class);
        
        $this->post(route('role.store'), $role->toArray())
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function a_role_requires_a_name()
    {
        $this->signInAdmin();
        
        $this->post_role(['name' => ''])
            ->assertSessionHasErrors(['name']);
    }
    
    /** @test */
    public function role_name_must_be_unique()
    {
        $this->signInAdmin();
        
        create(Role::class, ['name' => 'Test']);

        $this->post_role(['name' => 'Test'])
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_label()
    {
        $this->signInAdmin();
        
        $this->post_role(['label' => ''])
            ->assertSessionHasErrors(['label']);
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_create_a_role()
    {
        $this->signInDefault();

        $this->get(route('role.create'))->assertStatus(403);
        
        $this->post_role()->assertStatus(403);
    }

    /**
     * Post a new role
     *
     * @param array $overrides role overrides
     * @param array $permissions_ids role permissions ids
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function post_role($overrides = [], $permissions_ids = [])
    {
        $role = make(Role::class, $overrides);
        
        $data = array_merge($role->toArray(), [
            'permissions' => $permissions_ids
        ]);

        return $this->post(route('role.store'), $data);
    }
}
