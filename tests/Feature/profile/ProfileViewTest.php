<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;

class ProfileViewTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_other_users_profile()
    {
        $this->signInDefault();
        
        $this->viewProfile()->assertViewIs('profile.show');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_other_users_profile()
    {
        $this->signInRestricted();

        $this->viewProfile()->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_profile()
    {
        $this->viewProfile()->assertRedirect(route('login'));
    }

    /**
     * View user profile
     *
     * @param null $user
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function viewProfile($user = null)
    {
        if(! $user) {
            $user = create(User::class);
        }

        return $this->get(route('profile.show', ['user' => $user->id]));
    }
}
