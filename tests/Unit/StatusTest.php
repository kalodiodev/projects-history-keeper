<?php

namespace Tests\Unit;

use App\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_belongs_to_many_projects()
    {
        $tag = make(Status::class);

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $tag->projects
        );
    }
}