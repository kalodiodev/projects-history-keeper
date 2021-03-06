@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Create Role</h1>
        <p>Create a new role</p>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('role.store') }}">
                    @csrf

                    @include('role._form')

                    <button type="submit" class="mt-3 btn btn-primary">Store Role</button>
                </form>
            </div>
        </div>
    </div>
@endsection