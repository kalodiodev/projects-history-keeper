<div class="form-group">
    <label for="name">Name</label>
    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
           name="name"
           value="@if(isset($role)){{ old('name', $role->name) }}@else{{ old('name')}}@endif">

    @if ($errors->has('name'))
        <div class="invalid-feedback">
            {{ $errors->first('name') }}
        </div>
    @endif
</div>

<div class="form-group">
    <label for="label">Label</label>
    <input class="form-control{{ $errors->has('label') ? ' is-invalid' : '' }}"
           name="label"
           value="@if(isset($role)){{ old('label', $role->label) }}@else{{ old('label') }}@endif">

    @if ($errors->has('label'))
        <div class="invalid-feedback">
            {{ $errors->first('label') }}
        </div>
    @endif
</div>

<h3>Permissions</h3>

<div class="form-row">
    {{-- User Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>User</h4>
        @foreach(\App\Permission::where('name','like','%user%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                        checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Profile Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Profile</h4>
        @foreach(\App\Permission::where('name','like','%profile%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Role Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Role</h4>
        @foreach(\App\Permission::where('name','like','%role%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Project Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Project</h4>
        @foreach(\App\Permission::where('name','like','%project%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Tag Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Tag</h4>
        @foreach(\App\Permission::where('name','like','%tag%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Task Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Task</h4>
        @foreach(\App\Permission::where('name','like','%task%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Guide Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Guide</h4>
        @foreach(\App\Permission::where('name','like','%guide%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Snippet Permissions --}}
    <div class="col-md-4 mt-3">
        <h4>Snippet</h4>
        @foreach(\App\Permission::where('name','like','%snippet%')->get() as $permission)
            <div class="form-check">
                <input id="{{ $permission->name }}"
                       class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                       @if(((is_array(old('permissions')) && (in_array($permission->id, old('permissions')))) ||
                           (isset($role_permissions) && in_array($permission->id, $role_permissions))))
                       checked
                        @endif
                >
                <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
            </div>
        @endforeach
    </div>
</div>