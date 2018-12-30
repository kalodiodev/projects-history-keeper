<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store comment
     *
     * @param int $commentable_id
     * @param CommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($commentable_id, CommentRequest $request)
    {
        $redirect_route = str_replace('comment.store', 'show', $request->route()->getName());
        $redirect_route_param = str_replace('.comment.store', '', $request->route()->getName());
        $commentable_type = "\\App\\" . ucfirst($redirect_route_param);
        $commentable = $commentable_type::findOrFail($commentable_id);

        $commentable->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->user()->id
        ]);

        session()->flash('message', 'Comment posted successfully');

        return redirect()->route($redirect_route, [$redirect_route_param => $commentable->id]);
    }
}