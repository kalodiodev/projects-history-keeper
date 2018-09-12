<?php

namespace App\Http\Controllers;

use App\Guide;
use App\Http\Requests\GuideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class GuideController extends Controller
{
    /**
     * GuideController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index Guides
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function index()
    {
        if(Gate::denies('index', Guide::class)) {
            throw new AuthorizationException("You are not authorized for this action");
        }
        
        if(Gate::allows('view_all', Guide::class)) {
            $guides = Guide::paginate(14);
        } else {
            $guides = auth()->user()->guides()->paginate(14);
        }

        return view('guide.index', compact('guides'));
    }

    /**
     * Show Guide
     *
     * @param Guide $guide
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function show(Guide $guide)
    {
        if(Gate::denies('view', $guide)) {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('guide.show', compact('guide'));
    }

    /**
     * Create Guide
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        if(Gate::denies('create', Guide::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('guide.create');
    }

    /**
     * Store Guide
     *
     * @param GuideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(GuideRequest $request)
    {
        if(Gate::denies('create', Guide::class))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        Guide::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'body' => $request->get('body'),
            'featured_image' => $request->get('featured_image'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('guide.index');
    }

    /**
     * Edit Guide
     *
     * @param Guide $guide
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(Guide $guide)
    {
        if(Gate::denies('update', $guide))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        return view('guide.edit', compact('guide'));
    }

    /**
     * Update Guide
     *
     * @param Guide $guide
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Guide $guide, Request $request)
    {
        if(Gate::denies('update', $guide))
        {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $guide->update($request->only(['title', 'description', 'body']));

        return redirect()->route('guide.index');
    }

    /**
     * Delete guide
     *
     * @param Guide $guide
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Guide $guide)
    {
        if(Gate::denies('delete', $guide)) {
            throw new AuthorizationException("You are not authorized for this action");
        }

        $guide->delete();

        return redirect()->route('guide.index');
    }
}
