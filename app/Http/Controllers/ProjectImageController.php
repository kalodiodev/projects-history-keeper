<?php

namespace App\Http\Controllers;

use App\Project;
use App\Http\Requests\ImageRequest;

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
     * @param ImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Project $project, ImageRequest $request)
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
