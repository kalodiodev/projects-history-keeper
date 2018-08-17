<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class TagController extends Controller
{
    /**
     * TagController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index Tags
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function index()
    {
        if(Gate::denies('view', Tag::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $tags = Tag::paginate(30);

        return view('tag.index', compact('tags'));
    }

    /**
     * Create a tag
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        if(Gate::denies('create', Tag::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('tag.create');
    }

    /**
     * Store tag
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        if(Gate::denies('create', Tag::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        Tag::create([
            'name' => $request->get('name')
        ]);

        return redirect()->route('tag.index');
    }
}
