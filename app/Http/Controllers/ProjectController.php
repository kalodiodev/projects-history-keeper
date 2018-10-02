<?php

namespace App\Http\Controllers;

use App\Tag;
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
    public function index()
    {
        if(Gate::allows('view_all', Project::class)) {
            $projects = Project::paginate(14);
        } else {
            $projects = auth()->user()->projects()->paginate(14);
        }

        $tags = Tag::all();

        return view('project.index', compact('projects', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->isAuthorized('create', Project::class);

        $tags = Tag::all();
        
        return view('project.create', compact('tags'));
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
        $this->isAuthorized('create', Project::class);

        $project = Project::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description
        ]);

        $project->tags()->attach($request->tags);

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
        $this->isAuthorized('view', $project);

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
        $this->isAuthorized('update', $project);

        $tags = Tag::all();

        return view('project.edit', compact('project', 'tags'));
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
        $this->isAuthorized('update', $project);

        $project->update($request->only(['title', 'description']));

        $project->tags()->sync($request->get('tags'));

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
        $this->isAuthorized('delete', $project);

        $project->delete();

        return redirect()->route('project.index');
    }
}
