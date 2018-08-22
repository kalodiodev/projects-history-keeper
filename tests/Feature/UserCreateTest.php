<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class UserCreateTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_user_create()
    {
        $this->signInAdmin();

        $this->get(route('user.create'))
            ->assertStatus(200)
            ->assertViewIs('user.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_user_create()
    {
        $this->signInDefault();

        $this->get(route('user.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_user_create()
    {
        $this->get(route('user.create'))
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function an_authorized_user_can_store_a_user()
    {
        $this->signInAdmin();
        
        $this->post(route('user.store'), $this->userValidFields([], true))
            ->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', $this->userValidFields());
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_user()
    {
        $this->signInDefault();

        $this->post(route('user.store'), $this->userValidFields([], true))
            ->assertStatus(403);

        $this->assertDatabaseMissing('users', $this->userValidFields());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_user()
    {
        $this->post(route('user.store'), $this->userValidFields([], true))
            ->assertRedirect(route('login'));
    }

    /**
     * Get User Valid fields data
     *
     * @param array $overrides
     * @param bool $include_password
     * @return array
     */
    protected function userValidFields($overrides = [], $include_password = false)
    {
        $user_data = [
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ];

        if($include_password) {
            return array_merge($user_data, [
                'password'              => '12345678',
                'password_confirmation' => '12345678'
            ], $overrides);
        }

        return array_merge($user_data, $overrides);
    }
}
