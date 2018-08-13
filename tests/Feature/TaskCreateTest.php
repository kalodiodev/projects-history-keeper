<?php

namespace Tests\Feature;

use App\User;
use App\Task;
use App\Project;
use Tests\IntegrationTestCase;

class TaskCreateTest extends IntegrationTestCase
{
    /** @test */
    public function a_user_can_view_create_task_for_his_project()
    {
        $user = $this->signInDefault();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('task.create');
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_view_create_task_for_others_projects()
    {
        $this->signInDefault();
        
        $project = create(Project::class);
        
        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_view_create_task_for_any_project()
    {
        $this->signInAdmin();

        $project = create(Project::class);

        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertStatus(200)
            ->assertViewIs('task.create');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_create_task()
    {
        $project = create(Project::class);

        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_create_task()
    {
        $user = $this->signInRestricted();

        $project = create(Project::class, ['user_id' => $user->id]);

        $this->get(route('project.task.create', ['project' => $project->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function create_task_cannot_be_viewed_for_a_non_existent_project()
    {
        $this->signIn();

        $non_existent_project_id = 4;

        $this->get(route('project.task.create', ['project' => $non_existent_project_id]))
            ->assertStatus(404);
    }

    /** @test */
    public function an_authenticated_user_can_store_a_task_to_his_project()
    {
        $user = $this->signInDefault();

        $project = create(Project::class, ['user_id' => $user->id]);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertRedirect(route('project.show', ['project' => $project->id]));

        $this->assertDatabaseHas('tasks', [
            'project_id'  => $project->id,
            'user_id'     => $user->id,
            'title'       => $task->title,
            'description' => $task->description,
        ]);
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_task_to_others_projects()
    {
        $this->signInDefault();

        $project = create(Project::class);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertStatus(403);
    }
    
    /** @test */
    public function an_unauthorized_user_cannot_store_a_task_to_any_project()
    {
        $user = $this->signInRestricted();

        $project = create(Project::class, ['user_id' => $user->id]);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authorized_user_can_store_a_task_to_any_project()
    {
        $user = $this->signInAdmin();

        $project = create(Project::class);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertRedirect(route('project.show', ['project' => $project->id]));

        $this->assertDatabaseHas('tasks', [
            'project_id'  => $project->id,
            'user_id'     => $user->id,
            'title'       => $task->title,
            'description' => $task->description,
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_task()
    {
        $project = create(Project::class);
        $task = make(Task::class);

        $this->post(route('project.task.store', ['project' => $project->id]), $task->toArray())
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tasks', [
            'title'       => $task->title,
            'description' => $task->description
        ]);
    }

    /** @test */
    public function a_task_cannot_be_stored_for_a_non_existent_project()
    {
        $this->signIn();

        $non_existent_project_id = 4;

        $this->postTask([], $non_existent_project_id)
            ->assertStatus(404);
    }

    /** @test */
    public function a_task_requires_a_name()
    {
        $this->signIn();

        $this->postTask(['title' => ''])
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function task_title_length_should_within_the_right_limits()
    {
        $this->signIn();

        $this->postTask(['title' => str_random(4)])
            ->assertSessionHasErrors(['title']);

        $this->postTask(['title' => str_random(192)])
            ->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function task_date_must_be_of_type_date()
    {
        $this->signIn();

        $this->postTask(['date' => "2018-08-07"])
            ->assertSessionHasNoErrors();

        $this->postTask(['date' => 'a string'])
            ->assertSessionHasErrors(['date']);
    }

    /**
     * Post a Task
     *
     * @param array $overrides
     * @param $project_id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function postTask($overrides = [], $project_id = null)
    {
        $task = make(Task::class, $overrides);

        if(! $project_id) {
            $project_id = create(Project::class)->id;
        }

        return $this->post(route('project.task.store', ['project' => $project_id]), $task->toArray());
    }
}
