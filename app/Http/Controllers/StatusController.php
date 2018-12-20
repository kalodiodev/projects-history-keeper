<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Status Controller constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index statuses
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->isAuthorized('manage', Status::class);

        $statuses = Status::paginate(15);

        return view('status.index', compact('statuses'));
    }

    /**
     * Create Status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->isAuthorized('create', Status::class);

        return view('status.create');
    }

    /**
     * Store Status
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->isAuthorized('create', Status::class);

        Status::create($request->only(['title', 'color']));
        
        return redirect()->route('status.index');
    }

    /**
     * Edit Status
     *
     * @param Status $status
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Status $status)
    {
        $this->isAuthorized('update', $status);

        return view('status.edit', compact('status'));
    }

    /**
     * Update Status
     *
     * @param Request $request
     * @param Status $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Status $status)
    {
        $this->isAuthorized('update', $status);
        
        $status->update(
            $request->only([
                'title', 'color'
            ])
        );

        return redirect()->route('status.index');
    }

}
