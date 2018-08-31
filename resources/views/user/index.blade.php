@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Users</h1>
        <p>All users available</p>

        <table class="table table-responsive-sm">
            <thead>
            <tr>
                <td>ID</td>
                <td>Email</td>
                <td>Name</td>
                <td>Actions</td>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @can('edit', \App\User::class)
                            <a class="btn btn-warning" href="{{ route('user.edit', ['user' => $user->id]) }}">Edit</a>
                        @endcan
                        <a class="btn btn-danger"  href="">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center mt-3">
            {{ $users->links() }}
        </div>

        <div class="text-right mt-5">
            <a href="{{ route('invitation.create') }}" class="btn btn-primary">Invite User</a>
        </div>
    </div>
@endsection