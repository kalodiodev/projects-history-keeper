<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Image
     *
     * @param Image $image
     * @return mixed
     */
    public function show(Image $image)
    {
        $this->isAuthorized('view', $image->imageable);

        if(! Storage::has($image->fullpath())) {
            abort(404);
        }

        return response()->file(Storage::path($image->fullpath()));
    }

    /**
     * Delete Image
     *
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Image $image)
    {
        $this->isAuthorized('delete', $image->imageable);

        if(! Storage::has($image->fullpath())) {
            abort(404);
        }

        Storage::delete($image->fullpath());
        $image->delete();

        return redirect()->back();
    }
}
