<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Guide;
use Illuminate\Http\Request;
use App\Http\Requests\GuideRequest;
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
        $this->isAuthorized('index', Guide::class);

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
        $this->isAuthorized('view', $guide);

        return view('guide.show', compact('guide'));
    }

    /**
     * Create Guide
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->isAuthorized('create', Guide::class);

        $tags = Tag::all();

        return view('guide.create', compact('tags'));
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
        $this->isAuthorized('create', Guide::class);

        $guide = Guide::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'body' => $request->get('body'),
            'featured_image' => $request->get('featured_image'),
            'user_id' => auth()->user()->id
        ]);

        $guide->tags()->attach($request->tags);

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
        $this->isAuthorized('update', $guide);

        $tags = Tag::all();

        return view('guide.edit', compact('guide', 'tags'));
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
        $this->isAuthorized('update', $guide);

        $guide->update($request->only(['title', 'description', 'body']));

        $guide->tags()->sync($request->get('tags'));

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
        $this->isAuthorized('delete', $guide);

        $guide->delete();

        return redirect()->route('guide.index');
    }
}
