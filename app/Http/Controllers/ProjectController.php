<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Status;
use App\Project;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProjectRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectController extends TaggableController
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
        $projects = $this->projects();

        $tags = Tag::withProjects();

        $active_tag = $this->activeTag();

        return view('project.index', compact('projects', 'tags', 'active_tag'));
    }

    /**
     * Get projects
     *
     * @return mixed
     */
    private function projects()
    {
        if(Gate::allows('view_all', Project::class)) {
            if(request()->has('tag')) {
                return Project::ofTag(request('tag'))->paginate(14);
            }

            return Project::paginate(14);
        }

        if(request()->has('tag')) {
            return Project::ofTagAndUser(request('tag'), auth()->user())
                ->paginate(14);
        }

        return auth()->user()->projects()->paginate(14);
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
        $statuses = Status::all();
        
        return view('project.create', compact('tags', 'statuses'));
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
            'description' => $request->description,
            'status_id'   => $request->status_id
        ]);

        $project->tags()->attach($request->tags);

        session()->flash('message', 'Project stored successfully');

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
        
        $comments = $project->comments()->latest()->paginate(15);

        return view('project.show', compact('project', 'comments'));
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
        $statuses = Status::all();

        return view('project.edit', compact('project', 'tags', 'statuses'));
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

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'status_id'   => $request->status_id
        ]);

        $project->tags()->sync($request->get('tags'));

        session()->flash('message', 'Project updated successfully');

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

        session()->flash('message', 'Project deleted successfully');

        return redirect()->route('project.index');
    }
}
