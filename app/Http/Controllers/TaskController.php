<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests\TaskRequest;

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
     */
    public function create(Project $project)
    {
        return view('task.create', compact('project'));
    }

    /**
     * Store Task
     *
     * @param Project $project
     * @param TaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Project $project, TaskRequest $request)
    {
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
     */
    public function edit(Task $task)
    {
        return view('task.edit', compact('task'));
    }

    /**
     * Update Task
     *
     * @param Task $task
     * @param TaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Task $task, TaskRequest $request)
    {
        $task->update($request->only(['title', 'description', 'date']));

        return redirect()->route('project.show', ['project' => $task->project->id]);
    }
}
