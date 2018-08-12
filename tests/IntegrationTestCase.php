<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class IntegrationTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->seed(\DatabaseSeeder::class);
    }

    /**
     * Sign In user
     *
     * @param null $user
     * @return $this
     */
    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();
        $this->actingAs($user);

        return $this;
    }

    /**
     * Give user a role
     *
     * @param $user
     * @param $role
     */
    protected function giveUserRole($user, $role)
    {
        return $user->giveRole($role);
    }

    /**
     * Sign in a user with a given role
     *
     * @param $role
     * @param $overrides
     * @return mixed
     */
    protected function signInAs($role, $overrides = [])
    {
        $user = factory(User::class)->create($overrides);
        $this->signIn($user);
        return $this->giveUserRole($user, $role);
    }

    /**
     * Sign in User with Admin role
     *
     * @param array $overrides
     * @return mixed
     */
    protected function signInAdmin(array $overrides = [])
    {
        return $this->signInAs('admin', $overrides);
    }

    /**
     * Sign in User with Default role
     *
     * @param array $overrides
     * @return mixed
     */
    protected function signInDefault(array $overrides = [])
    {
        return $this->signInAs('default', $overrides);
    }

    /**
     * Sign in User with Restricted role
     *
     * @param array $overrides
     * @return mixed
     */
    protected function signInRestricted(array $overrides = [])
    {
        create(Role::class, ['name' => 'restricted']);
        return $this->signInAs('restricted', $overrides);
    }
}