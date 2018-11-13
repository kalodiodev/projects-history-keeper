<?php

namespace App\Http\Controllers;

use App\Role;
use App\Http\Requests\RoleRequest;

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
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only(['name', 'label']));
        $role->permissions()->sync($request->permissions);

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
        $role_permissions = $role->permissions->pluck('id')->toArray();

        return view('role.edit', compact('role', 'role_permissions'));
    }

    /**
     * Update Role
     *
     * @param Role $role
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, RoleRequest $request)
    {
        $role->update($request->only(['name', 'label']));
        $role->permissions()->sync($request->permissions);

        return redirect()->route('role.index');
    }
}
