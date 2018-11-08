<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Index Roles
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->isAuthorized('view', Role::class);
        
        $roles = Role::paginate(14);

        return view('role.index', compact('roles'));
    }

    /**
     * Create Role
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store Role
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $permissions = Permission::all()->pluck('name')->toArray();
        $role = Role::create($request->only(['name', 'label']));
        $role->grantPermissions(array_keys($request->only($permissions)));

        return redirect()->route('role.index');
    }

    /**
     * Edit Role
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $role_permissions = $role->permissions->pluck('name')->toArray();

        return view('role.edit', compact('role', 'role_permissions'));
    }
}
