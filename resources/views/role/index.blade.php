@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Roles</h1>
        <p>All roles available</p>

        <table class="table table-responsive-sm">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Label</td>
                <td>Action</td>
            </tr>
            </thead>

            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->label }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('role.edit', ['role' => $role->id]) }}">Edit</a>
                        <a class="btn btn-danger"  href="">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center mt-3">
            {{ $roles->links() }}
        </div>

        <div class="text-right mt-5">
            <a href="{{ route('role.create') }}" class="btn btn-primary">Add Role</a>
        </div>
    </div>
@endsection