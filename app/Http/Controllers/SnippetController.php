<?php

namespace App\Http\Controllers;

use App\Snippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class SnippetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create Snippet
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        if(Gate::denies('create', Snippet::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('snippet.create');
    }
}
