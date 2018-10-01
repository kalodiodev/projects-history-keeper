<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\TagRequest;
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
        $this->isAuthorized('manage', Tag::class);

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
        $this->isAuthorized('create', Tag::class);

        return view('tag.create');
    }

    /**
     * Store tag
     *
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(TagRequest $request)
    {
        $this->isAuthorized('create', Tag::class);

        Tag::create([
            'name' => $request->get('name')
        ]);

        return redirect()->route('tag.index');
    }

    /**
     * Edit Tag
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(Tag $tag)
    {
        $this->isAuthorized('update', Tag::class);

        return view('tag.edit', compact('tag'));
    }

    /**
     * Update Tag
     *
     * @param Tag $tag
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Tag $tag, TagRequest $request)
    {
        $this->isAuthorized('update', Tag::class);

        $tag->update($request->only(['name']));

        return redirect()->route('tag.index');
    }

    /**
     * Delete Tag
     *
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        $this->isAuthorized('delete', Tag::class);

        $tag->delete();

        return redirect()->route('tag.index');
    }
}
