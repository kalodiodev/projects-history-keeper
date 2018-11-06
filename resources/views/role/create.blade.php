@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Create Role</h1>
        <p>Create a new role</p>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" name="name" value="">
                    </div>

                    <div class="form-group">
                        <label for="label">Label</label>
                        <input class="form-control" name="label" value="">
                    </div>

                    <h3>Permissions</h3>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <h4>User</h4>
                            @foreach(\App\Permission::where('name','like','%project%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-4 mt-3">
                            <h4>Profile</h4>
                            @foreach(\App\Permission::where('name','like','%profile%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4 mt-3">
                            <h4>Role</h4>
                            @foreach(\App\Permission::where('name','like','%role%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4 mt-3">
                            <h4>Project</h4>
                            @foreach(\App\Permission::where('name','like','%project%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4 mt-3">
                            <h4>Tag</h4>
                            @foreach(\App\Permission::where('name','like','%tag%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4 mt-3">
                            <h4>Task</h4>
                            @foreach(\App\Permission::where('name','like','%task%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4 mt-3">
                            <h4>Guide</h4>
                            @foreach(\App\Permission::where('name','like','%guide%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-4 mt-3">
                            <h4>Snippet</h4>
                            @foreach(\App\Permission::where('name','like','%snippet%')->get() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $permission->name }}">
                                    <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="mt-3 btn btn-primary">Store Role</button>
                </form>
            </div>
        </div>
    </div>
@endsection