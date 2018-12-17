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
        $statuses = Status::paginate(15);

        return view('status.index', compact('statuses'));
    }

}
