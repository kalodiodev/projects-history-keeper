<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests\TaskRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

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
        if(Gate::denies('create', [Task::class, $project]))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

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
        if(Gate::denies('create', [Task::class, $project]))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }
        
        Task::create(array_merge([
            'project_id'  => $project->id,
            'user_id'     => auth()->user()->id
        ], $request->only(['title', 'description', 'date'])));

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
        if(Gate::denies('update', $task))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

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
        if(Gate::denies('update', $task))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $task->update($request->only(['title', 'description', 'date']));

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
        $task->delete();
        
        return redirect()->route('project.show', ['project' => $task->project->id]);
    }
}
