<?php

namespace App\Http\Controllers;

use App\Guide;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuideImageController extends Controller
{
    /**
     * GuideImageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function featured($featured)
    {
        if(! Storage::has('/images/guide/' . $featured)) {
            abort(404);
        }

        return response()->file(Storage::path('/images/guide/'. $featured));
    }

    /**
     * Store guide image
     *
     * @param Guide $guide
     * @param ImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Guide $guide, ImageRequest $request)
    {
        $this->isAuthorized('update', $guide);
        
        $stored_image = $request->file('image')->store('images');

        $guide->images()->create([
            'file' => ltrim($stored_image, 'images/'),
            'path' => 'images/'
        ]);

        session()->flash('message', 'Image stored successfully');

        return redirect()->route('guide.show', ['guide' => $guide->id]);
    }
}
