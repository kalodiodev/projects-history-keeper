<?php

namespace Tests\Feature\role;

use App\Role;
use Tests\IntegrationTestCase;

class RoleEditTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_role_edit_page()
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

    /** @test */
    public function a_role_requires_a_name()
    {
        $this->signInAdmin();

        $role = create(Role::class);

        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData(['name' => '']))
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_role_requires_a_label()
    {
        $this->signInAdmin();

        $role = create(Role::class);

        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData(['label' => '']))
            ->assertSessionHasErrors(['label']);
    }

    /** @test */
    public function role_name_must_be_unique()
    {
        $this->signInAdmin();

        create(Role::class, ['name' => 'Test']);
        $role = create(Role::class, ['name' => 'Test2']);

        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData(['name' => 'Test']))
            ->assertSessionHasErrors(['name']);

        // Updating a role without changing name
        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData(['name' => 'Test2']))
            ->assertSessionHasNoErrors();
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_edit_role()
    {
        $this->signInDefault();

        $role = create(Role::class);
        
        $this->get(route('role.edit', ['role' => $role->id]))
            ->assertStatus(403);

        $this->patch(route('role.update', ['role' => $role->id]), $this->updateData())
            ->assertStatus(403);
    }

    protected function updateData($overrides = [])
    {
        return array_merge([
            'name' => 'New Name',
            'label' => 'New Label',
            'permissions' => [
                '3'
            ]
        ], $overrides);
    }
}
