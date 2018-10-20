<?php

namespace Tests\Feature;

use App\Guide;
use Tests\IntegrationTestCase;

class GuideDeleteTest extends IntegrationTestCase
{
    /** @test */
    public function a_guide_can_be_deleted_by_its_creator()
    {
        $user = $this->signInDefault();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->delete(route('guide.destroy', ['guide' => $guide->id]))
            ->assertRedirect(route('guide.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseMissing('guides', $guide->toArray());
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_other_users_guides()
    {
        $this->signInDefault();

        $guide = create(Guide::class);

        $this->delete(route('guide.destroy', ['guide' => $guide->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_any_guide()
    {
        $user = $this->signInRestricted();

        $guide = create(Guide::class, ['user_id' => $user->id]);

        $this->delete(route('guide.destroy', ['guide' => $guide->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_any_guide()
    {
        $this->signInAdmin();

        $guide = create(Guide::class);

        $this->delete(route('guide.destroy', ['guide' => $guide->id]))
            ->assertRedirect(route('guide.index'))
            ->assertSessionHas('message');

        $this->assertDatabaseMissing('guides', $guide->toArray());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_guide()
    {
        $guide = create(Guide::class);

        $this->delete(route('guide.destroy', ['guide' => $guide->id]))
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('guides', $guide->toArray());
    }
}
