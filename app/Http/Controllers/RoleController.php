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
        $this->isAuthorized('create', Role::class);

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
        $this->isAuthorized('create', Role::class);
        
        $role = Role::create($request->only(['name', 'label']));
        $role->permissions()->sync($request->permissions);

        session()->flash('message', 'Role created successfully');

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
        $this->isAuthorized('update', Role::class);
        
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
        $this->isAuthorized('update', Role::class);
        
        $role->update($request->only(['name', 'label']));
        $role->permissions()->sync($request->permissions);

        session()->flash('message', 'Role updated successfully');

        return redirect()->route('role.index');
    }

    /**
     * Delete Role
     * 
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $this->isAuthorized('delete', Role::class);
        
        if($role->isLocked()) {
            return abort(403);
        }
        
        if(! $role->isAssigned()) {
            $role->delete();
            session()->flash('message', 'Role deleted successfully');
        } else {
            session()->flash('error-message', 'Role is assigned to Users, cannot be deleted');
        }

        return redirect()->route('role.index');
    }
}
