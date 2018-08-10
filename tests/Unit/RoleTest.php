<?php

namespace Tests\Unit;

use App\Permission;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_has_users()
    {
        $role = make(Role::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $role->users
        );
    }
    
    /** @test */
    public function a_role_belongs_to_many_permissions()
    {
        $role = make(Role::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $role->permissions
        );
    }

    /** @test */
    public function a_role_can_be_assigned_to_user()
    {
        $role = create(Role::class);

        $role->assignRoleTo($user = create(User::class));

        $this->assertDatabaseHas('users', [
            'id'      => $user->id,
            'role_id' => $role->id
        ]);
    }

    /** @test */
    public function it_gives_permission_to_role()
    {
        $role = create(Role::class);

        // Permission Model
        $role->grantPermission(create(Permission::class));
        
        // Permission array
        $role->grantPermission(create(Permission::class)->toArray());

        // Permission name
        $role->grantPermission(create(Permission::class)->name);

        $this->assertEquals($role->permissions->count(), 3);
    }
    
    /** @test */
    public function it_gives_permissions_to_role()
    {
        $role = create(Role::class);
        
        $role->grantPermissions($permissions = create(Permission::class, [], 4)->toArray());
        
        $this->assertEquals($role->permissions->count(), 4);
    }
}