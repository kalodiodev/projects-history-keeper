<div class="form-group">
    <label for="name">Name</label>
    <input class="form-control" name="name"
           value="@if(isset($role)){{ old('name', $role->name) }}@else{{ old('name')}}@endif">
</div>

<div class="form-group">
    <label for="label">Label</label>
    <input class="form-control" name="label"
           value="@if(isset($role)){{ old('label', $role->label) }}@else{{ old('label') }}@endif">
</div>

<h3>Permissions</h3>

<div class="row">
    <div class="col-md-4 mt-3">
        <h4>User</h4>
        @foreach(\App\Permission::where('name','like','%project%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>
    <div class="col-md-4 mt-3">
        <h4>Profile</h4>
        @foreach(\App\Permission::where('name','like','%profile%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 mt-3">
        <h4>Role</h4>
        @foreach(\App\Permission::where('name','like','%role%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 mt-3">
        <h4>Project</h4>
        @foreach(\App\Permission::where('name','like','%project%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 mt-3">
        <h4>Tag</h4>
        @foreach(\App\Permission::where('name','like','%tag%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 mt-3">
        <h4>Task</h4>
        @foreach(\App\Permission::where('name','like','%task%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 mt-3">
        <h4>Guide</h4>
        @foreach(\App\Permission::where('name','like','%guide%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif>
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    <div class="col-md-4 mt-3">
        <h4>Snippet</h4>
        @foreach(\App\Permission::where('name','like','%snippet%')->get() as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="{{ $permission->name }}"
                       @if(! empty(old($permission->name)) || (isset($role_permissions) && in_array($permission->name, $role_permissions)))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>
</div>