<?php

namespace Tests\Feature;

use App\User;
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

    /** @test */
    public function a_user_requires_a_name()
    {
        $this->signInAdmin();

        $this->post(route('user.store'), $this->userValidFields(['name' => ''], true))
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function a_user_requires_an_email()
    {
        $this->signInAdmin();

        $this->post(route('user.store'), $this->userValidFields(['email' => ''], true))
            ->assertSessionHasErrors(['email']);

        $this->post(route('user.store'), $this->userValidFields(['email' => 'not an email'], true))
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function users_email_should_be_unique()
    {
        create(User::class, ['email' => $this->userValidFields()['email']]);

        $this->signInAdmin();

        $this->post(route('user.store'), $this->userValidFields(['email' => ''], true))
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function a_user_requires_a_password()
    {
        $this->signInAdmin();

        $this->post(route('user.store'), $this->userValidFields([], false))
            ->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function users_password_must_be_confirmed()
    {
        $this->signInAdmin();

        $this->post(route('user.store'), $this->userValidFields(['password_confirmation' => ''], true))
            ->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function users_password_cannot_be_less_than_six_characters()
    {
        $this->signInAdmin();

        $this->post(route('user.store'), $this->userValidFields([
            'password'              => '1234',
            'password_confirmation' => '1234',
        ]))->assertSessionHasErrors(['password']);
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
