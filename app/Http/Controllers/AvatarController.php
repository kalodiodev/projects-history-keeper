<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
     * Update Avatar
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        /** @var UploadedFile $avatar */
        $avatar = $request->file('avatar')->store('images/avatars');

        $user->update(['avatar' => ltrim($avatar, 'images')]);

        return redirect()->route('profile.edit');
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
