<?php

namespace Tests\Feature;

use App\Project;
use App\Tag;
use Tests\IntegrationTestCase;

class ProjectIndexTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_own_projects_index()
    {
        $user = $this->signInDefault();
        create(Project::class, ['user_id' => $user->id], 2);
        create(Project::class, [], 2);

        $responses = $this->get(route('project.index'))
            ->assertStatus(200)
            ->assertViewIs('project.index')
            ->assertViewHas(['projects']);

        $projects = $responses->original->getData()['projects'];
        $this->assertEquals(2, $projects->count());
    }

    /** @test */
    public function an_authorized_user_can_view_all_projects_index()
    {
        $user = $this->signInAdmin();
        create(Project::class, ['user_id' => $user->id], 2);
        create(Project::class, [], 2);

        $responses = $this->get(route('project.index'))
            ->assertStatus(200)
            ->assertViewIs('project.index')
            ->assertViewHas(['projects']);

        $projects = $responses->original->getData()['projects'];
        $this->assertEquals(4, $projects->count());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_projects_index()
    {
        $this->get(route('project.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_admin_can_index_all_projects_by_tag()
    {
        $this->signInAdmin();
        
        $firstTag = create(Tag::class);
        $secondTag = create(Tag::class);

        $this->createProjectsOfTag($firstTag, 4);
        $this->createProjectsOfTag($secondTag, 3);

        $responses = $this->get(route('project.index', ['tag' => $firstTag->name]))
            ->assertStatus(200);

        $projects = $responses->original->getData()['projects'];
        $this->assertEquals(4, $projects->count());
    }

    /** @test */
    public function a_default_user_can_index_only_their_projects_by_tag()
    {
        $this->withoutExceptionHandling();
        
        $user = $this->signInDefault();

        $firstTag = create(Tag::class);
        $secondTag = create(Tag::class);

        $this->createProjectsOfTag($firstTag, 2);
        $this->createProjectsOfTag($secondTag, 3);

        // User's projects
        $this->createProjectsOfTag($firstTag, 1, ['user_id' => $user->id]);

        $responses = $this->get(route('project.index', ['tag' => $firstTag->name]))
            ->assertStatus(200);

        $projects = $responses->original->getData()['projects'];
        $this->assertEquals(1, $projects->count());
    }

    /**
     * Create Projects with given tag
     *
     * @param $tag
     * @param $projectsNumber
     * @param array $overrides
     * @return mixed
     */
    private function createProjectsOfTag($tag, $projectsNumber, $overrides = [])
    {
        $projects = create(Project::class, $overrides, $projectsNumber);
        foreach ($projects as $project) {
            $project->tags()->attach($tag);
        }

        return $projects;
    }
}
