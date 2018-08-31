<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index Users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function index()
    {
        if(Gate::denies('manage', User::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $users = User::paginate(40);

        return view('user.index', compact('users'));
    }

    /**
     * Edit User
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        if(Gate::denies('edit', User::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update User
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(User $user, Request $request)
    {
        if(Gate::denies('edit', User::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $user->update($request->only(['name', 'role_id']));

        if($this->isAuthenticatedUser($user)) {
            auth()->setUser($user->fresh());
        }

        if(Gate::denies('manage', User::class)) {
            return redirect('/');
        }

        return redirect()->route('user.index');
    }

    /**
     * Check if user is the authenticated user
     *
     * @param $user
     * @return bool
     */
    protected function isAuthenticatedUser($user)
    {
        return $user->id == auth()->user()->id;
    }
}
