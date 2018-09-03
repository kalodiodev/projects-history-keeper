<?php

namespace App\Http\Controllers;


use App\Guide;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
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
}
