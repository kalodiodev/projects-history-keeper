<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Edit Profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update Profile
     *
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->only(['name', 'email', 'slogan', 'bio']));

        return redirect()->route('home');
    }
}
