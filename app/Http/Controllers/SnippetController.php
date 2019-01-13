<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Snippet;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SnippetRequest;
use Illuminate\Auth\Access\AuthorizationException;

class SnippetController extends TaggableController
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
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->isAuthorized('index', Snippet::class);

        $snippets = $this->snippets();

        $tags = Tag::withSnippets();

        $active_tag = $this->activeTag();

        return view('snippet.index', compact('snippets', 'tags', 'active_tag'));
    }

    /**
     * Show Snippet
     *
     * @param Snippet $snippet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function show(Snippet $snippet)
    {
        $this->isAuthorized('view', $snippet);

        return view('snippet.show', compact('snippet'));
    }

    /**
     * Create Snippet
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->isAuthorized('create', Snippet::class);

        $tags = Tag::all();

        return view('snippet.create', compact('tags'));
    }

    /**
     * Store Snippet
     *
     * @param SnippetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(SnippetRequest $request)
    {
        $this->isAuthorized('create', Snippet::class);

        $snippet = Snippet::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'code'        => $request->code
        ]);
        
        $snippet->tags()->attach($request->tags);

        session()->flash('message', 'Snippet created successfully');

        return redirect()->route('snippet.index');
    }

    /**
     * Edit Snippet
     *
     * @param Snippet $snippet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(Snippet $snippet)
    {
        $this->isAuthorized('update', $snippet);

        $tags = Tag::all();

        return view('snippet.edit', compact('snippet', 'tags'));
    }

    /**
     * Update Snippet
     *
     * @param Snippet $snippet
     * @param SnippetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Snippet $snippet, SnippetRequest $request)
    {
        $this->isAuthorized('update', $snippet);

        $snippet->update($request->only(['title', 'description', 'code']));

        $snippet->tags()->sync($request->get('tags'));

        session()->flash('message', 'Snippet updated successfully');

        return redirect()->route('snippet.index');
    }

    /**
     * Delete Snippet
     *
     * @param Snippet $snippet
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Snippet $snippet)
    {
        $this->isAuthorized('delete', $snippet);

        $snippet->delete();

        session()->flash('message', 'Snippet deleted successfully');

        return redirect()->route('snippet.index');
    }

    /**
     * Get guides
     *
     * @return mixed
     */
    private function snippets()
    {
        if(Gate::allows('view_all', Snippet::class)) {
            if(request()->has('tag')) {
                return Snippet::ofTag(request('tag'))->paginate(14);
            }

            return Snippet::paginate(14);
        }

        if(request()->has('tag')) {
            return Snippet::ofTagAndUser(request('tag'), auth()->user())
                ->paginate(14);
        }

        return auth()->user()->snippets()->paginate(14);
    }
}
