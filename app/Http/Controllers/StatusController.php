<?php

namespace App\Http\Controllers;

use App\Status;

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

}
