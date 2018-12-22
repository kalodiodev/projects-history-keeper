<?php

namespace Tests\Unit;

use App\Status;
use App\Project;
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

    /** @test */
    public function it_determines_whether_status_has_been_assigned_to_any_project()
    {
        $status = create(Status::class);

        $this->assertFalse($status->fresh()->isAssigned());

        create(Project::class, ['status_id' => $status->id]);

        $this->assertTrue($status->fresh()->isAssigned());
    }
}