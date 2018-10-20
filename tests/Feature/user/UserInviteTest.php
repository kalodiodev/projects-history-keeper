<?php

namespace Tests\Feature;

use App\Invitation;
use App\User;
use Illuminate\Support\Facades\Notification;
use Tests\IntegrationTestCase;

class UserInviteTest extends IntegrationTestCase
{
    /** @test */
    public function an_authorized_user_can_view_user_invite()
    {
        $this->signInAdmin();

        $this->get(route('invitation.create'))
            ->assertStatus(200)
            ->assertViewIs('invitation.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_user_invite()
    {
        $this->signInDefault();

        $this->get(route('invitation.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_user_invite()
    {
        $this->get(route('invitation.create'))
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function an_authorized_user_can_invite_a_user()
    {
        $this->signInAdmin();
        
        $this->post(route('invitation.store'), $this->userValidFields([]))
            ->assertRedirect(route('user.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseHas('invitations', $this->userValidFields());
    }

    /** @test */
    public function an_unauthorized_user_cannot_invite_a_user()
    {
        $this->signInDefault();

        $this->post(route('invitation.store'), $this->userValidFields([]))
            ->assertStatus(403);

        $this->assertDatabaseMissing('invitations', $this->userValidFields());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_invite_a_user()
    {
        $this->post(route('invitation.store'), $this->userValidFields([]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_invitation_requires_an_email()
    {
        $this->signInAdmin();

        $this->post(route('invitation.store'), $this->userValidFields(['email' => '']))
            ->assertSessionHasErrors(['email']);

        $this->post(route('invitation.store'), $this->userValidFields(['email' => 'not an email']))
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function a_user_cannot_invite_an_already_registered_user()
    {
        create(User::class, ['email' => $this->userValidFields()['email']]);

        $this->signInAdmin();

        $this->post(route('invitation.store'), $this->userValidFields(['email' => '']))
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function when_inviting_a_user_an_invitation_email_is_sent()
    {
        Notification::fake();

        $this->signInAdmin();

        $this->post(route('invitation.store'), $this->userValidFields(['email']))
            ->assertStatus(302);
        
        $invitation = Invitation::first();

        $invitationToken = '';

        Notification::assertSentTo(
            $invitation,
            \App\Notifications\Invitation::class,
            function ($notification, $channels) use (&$invitationToken) {
                $invitationToken = $notification->token;
                return true;
            });

        $this->assertEquals($invitation->token, $invitationToken);
    }
    
    /**
     * Get User Valid fields data
     *
     * @param array $overrides
     * @return array
     */
    protected function userValidFields($overrides = [])
    {
        $user_data = [
            'email' => 'test@example.com',
        ];

        return array_merge($user_data, $overrides);
    }
}
