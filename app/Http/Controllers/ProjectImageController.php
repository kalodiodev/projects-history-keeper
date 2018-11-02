<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectImageController extends Controller
{
    /**
     * ProjectImageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store Project Image
     *
     * @param Project $project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Project $project, Request $request)
    {
        $this->isAuthorized('upload_image', $project);

        $stored_image = $request->file('image')->store('images');

        $project->images()->create([
            'file' => ltrim($stored_image, 'images/'),
            'path' => 'images/'
        ]);

        session()->flash('message', 'Image stored successfully');

        return redirect()->route('project.show', ['project' => $project->id]);
    }
}