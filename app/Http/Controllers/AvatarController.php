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

        $this->validateAvatar($request);

        /** @var UploadedFile $avatar */
        $avatar = $request->file('avatar')->store('images/avatars');

        if($user->hasAvatar()) {
            Storage::delete('images' . $user->avatar);
        }

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

    /**
     * Delete avatar
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $user = auth()->user();

        if(Storage::has('images/' . $user->avatar)) {
            Storage::delete('images/' . $user->avatar);
        }

        $user->update([
            'avatar' => null
        ]);

        return redirect()->route('profile.edit');
    }

    /**
     * Validate Avatar request
     *
     * @param Request $request
     */
    protected function validateAvatar(Request $request)
    {
        $rules = [
            'avatar' => 'mimes:jpeg,png|dimensions:min_width=100,min_height=100,max_width=300,max_height=300'
        ];

        return $request->validate($rules);
    }
}
