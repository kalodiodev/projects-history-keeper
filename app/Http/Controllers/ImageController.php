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
        if(! Storage::has($image->fullpath())) {
            abort(404);
        }

        return response()->file(Storage::path($image->fullpath()));
    }
}
