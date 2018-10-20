<?php

namespace App\Http\Controllers;

use App\User;
use App\Invitation;
use App\Http\Requests\InvitationRequest;
use Illuminate\Auth\Access\AuthorizationException;

class InvitationController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->isAuthorized('invite', User::class);

        return view('invitation.create');
    }

    /**
     * Store User
     *
     * @param InvitationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(InvitationRequest $request)
    {
        $this->isAuthorized('invite', User::class);

        Invitation::create($request->only(['email']));

        session()->flash('message', 'Invitation sent');

        return redirect()->route('user.index');
    }
}
