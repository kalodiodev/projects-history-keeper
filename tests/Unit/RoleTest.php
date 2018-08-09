<?php

namespace Tests\Unit;

use App\Role;
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
}