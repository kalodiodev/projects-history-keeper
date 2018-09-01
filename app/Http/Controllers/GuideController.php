<?php

namespace App\Http\Controllers;


use App\Guide;
use Illuminate\Auth\Access\AuthorizationException;
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
}
