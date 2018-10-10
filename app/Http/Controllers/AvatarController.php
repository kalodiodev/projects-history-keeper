<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * AvatarController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show avatar image
     *
     * @param $avatar
     * @return mixed
     */
    public function show($avatar)
    {
        if(! Storage::has('images/avatars/' . $avatar)) {
            abort(404);
        }

        return response()->file(Storage::path('images/avatars/' . $avatar));
    }
}
