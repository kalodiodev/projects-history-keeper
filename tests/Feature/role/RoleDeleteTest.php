<?php

namespace Tests\Feature\role;

use App\Role;
use App\User;
use Tests\IntegrationTestCase;

class RoleDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_delete_a_role()
    {
        $this->signInAdmin();
        
        $role = create(Role::class);
        
        $this->delete(route('role.destroy', ['role' => $role->id]))
            ->assertRedirect(route('role.index'))
            ->assertSessionHas('message');
        
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_role() 
    {
        $role = create(Role::class);
        
        $this->delete(route('role.destroy', ['role' => $role->id]))
            ->assertRedirect(route('login'));
        
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }
    
    /** @test */
    public function a_role_can_not_be_deleted_if_it_is_assigned_to_user()
    {
        $this->signInAdmin();
        
        $role = create(Role::class);
        $role->assignRoleTo(create(User::class));

        $this->delete(route('role.destroy', ['role' => $role->id]))
            ->assertRedirect(route('role.index'))
            ->assertSessionHas('error-message');

        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_role()
    {
        $this->signInRestricted();
        
        $role = create(Role::class);
        
        $this->delete(route('role.destroy', ['role' => $role->id]))
            ->assertStatus(403);
    }
}
