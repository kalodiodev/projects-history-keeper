<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
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
        $this->isAuthorized('manage', User::class);

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
        $this->isAuthorized('edit', User::class);

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
        $this->isAuthorized('edit', User::class);

        $this->updateUser($user, $request->only(['name', 'role_id']));

        if($this->isAuthenticatedUser($user)) {
            auth()->setUser($user->fresh());
        }

        if(Gate::allows('manage', User::class)) {
            session()->flash('message', 'User updated successfully');

            return redirect()->route('user.index');
        }

        return redirect('/');
    }

    /**
     * Validate and update user
     *
     * @param $user
     * @param $data
     */
    protected function updateUser(User $user, $data)
    {
        $this->updateValidator($data)->validate();
        $user->update($data);
    }

    /**
     * Get a validator for an incoming user update request.
     *
     * @param $data
     * @return mixed
     */
    protected function updateValidator($data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'role_id' => 'required|integer|exists:roles,id'
        ]);
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
