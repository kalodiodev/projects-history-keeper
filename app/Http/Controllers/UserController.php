<?php

namespace App\Http\Controllers;

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
     * Create User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        if(Gate::denies('create', User::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('user.create');
    }
}
