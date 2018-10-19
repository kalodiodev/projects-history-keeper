<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests\TaskRequest;
use Illuminate\Auth\Access\AuthorizationException;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create Task
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create(Project $project)
    {
        $this->isAuthorized('create', [Task::class, $project]);

        return view('task.create', compact('project'));
    }

    /**
     * Store Task
     *
     * @param Project $project
     * @param TaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Project $project, TaskRequest $request)
    {
        $this->isAuthorized('create', [Task::class, $project]);

        Task::create(array_merge([
            'project_id'  => $project->id,
            'user_id'     => auth()->user()->id
        ], $request->only(['title', 'description', 'date'])));

        session()->flash('message', 'Task created successfully');

        return redirect()->route('project.show', ['project' => $project->id]);
    }

    /**
     * Edit Task
     *
     * @param Task $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(Task $task)
    {
        $this->isAuthorized('update', $task);

        return view('task.edit', compact('task'));
    }

    /**
     * Update Task
     *
     * @param Task $task
     * @param TaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Task $task, TaskRequest $request)
    {
        $this->isAuthorized('update', $task);

        $task->update($request->only(['title', 'description', 'date']));

        session()->flash('message', 'Task updated successfully');

        return redirect()->route('project.show', ['project' => $task->project->id]);
    }

    /**
     * Delete Task
     *
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $this->isAuthorized('delete', $task);

        $task->delete();

        session()->flash('message', 'Task deleted successfully');
        
        return redirect()->route('project.show', ['project' => $task->project->id]);
    }
}
