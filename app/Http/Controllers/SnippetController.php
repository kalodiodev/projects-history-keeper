<?php

namespace App\Http\Controllers;

use App\Snippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class SnippetController extends Controller
{
    /**
     * SnippetController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index Snippets
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $snippets = Snippet::paginate(30);

        return view('snippet.index', compact('snippets'));
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

    /**
     * Store Snippet
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        if(Gate::denies('create', Snippet::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        auth()->user()
            ->snippets()
            ->create($request->only(['title', 'description', 'code']));

        return redirect()->route('snippet.index');
    }
}
