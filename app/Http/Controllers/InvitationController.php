<?php

namespace App\Http\Controllers;

use App\User;
use App\Invitation;
use Illuminate\Support\Facades\Gate;
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
        if(Gate::denies('invite', User::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

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
        if(Gate::denies('invite', User::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        Invitation::create($request->only(['email']));

        return redirect()->route('user.index');
    }
}
