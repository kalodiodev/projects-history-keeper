<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;

class MakeAdminCommandTest extends IntegrationTestCase
{
    /** @test */
    public function it_generates_a_new_admin_user()
    {
        $this->artisan('make:admin')
            ->expectsQuestion("What name the admin should have?", "JohnDoe")
            ->expectsQuestion("And the email address?", "john@example.com")
            ->expectsQuestion("And the password?", "password")
            ->expectsQuestion("Confirm the password?", "password")
            ->expectsOutput('Admin account has been created created.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', ['name' => 'JohnDoe']);
    }

    /** @test */
    public function admin_requires_valid_fields()
    {
        $this->artisan('make:admin')
            ->expectsQuestion("What name the admin should have?", "")
            ->expectsQuestion("And the email address?", "")
            ->expectsQuestion("And the password?", "")
            ->expectsQuestion("Confirm the password?", "password")
            ->expectsOutput('Admin User not created. See error messages below:')
            ->assertExitCode(1);

        $this->assertDatabaseMissing('users', ['name' => 'JohnDoe']);
    }
}
