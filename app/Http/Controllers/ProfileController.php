<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\ProfileRequest;
use Illuminate\Auth\Access\AuthorizationException;

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

    /**
     * Update Avatar
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_avatar(Request $request)
    {
        $user = auth()->user();

        /** @var UploadedFile $avatar */
        $avatar = $request->file('avatar')->store('images/avatars');

        $user->update(['avatar' => $avatar]);

        return redirect()->route('profile.edit');
    }

    /**
     * Show User profile
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->isAuthorized('profile_view', User::class);

        return view('profile.show', compact('user'));
    }
}
