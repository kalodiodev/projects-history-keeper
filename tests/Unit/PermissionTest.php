<?php

namespace Tests\Unit;

use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_permission_belongs_to_many_roles()
    {
        $permission = make(Permission::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $permission->roles
        );
    }
}