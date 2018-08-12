<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProjectRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function index() {

        if(Gate::allows('view_all', Project::class)) {
            $projects = Project::paginate(14);
        } else {
            $projects = auth()->user()->projects()->paginate(14);
        }

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function create()
    {
        if(Gate::denies('create', Project::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }
        
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function store(ProjectRequest $request)
    {
        if(Gate::denies('create', Project::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        Project::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('project.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function show(Project $project)
    {
        if(Gate::denies('view', $project))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function edit(Project $project)
    {
        if(Gate::denies('update', $project))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(ProjectRequest $request, Project $project)
    {
        if(Gate::denies('update', $project))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $project->update($request->only(['title', 'description']));

        return redirect()->route('project.show', ['project' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        if(Gate::denies('delete', $project))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $project->delete();

        return redirect()->route('project.index');
    }
}
