@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Edit Role</h1>
        <p>Edit role <strong>{{ $role->name }}</strong></p>

        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('role.update', ['role' => $role->id]) }}">
                    {{ method_field('PATCH') }}
                    @csrf

                    @include('role._form')

                    @if(! $role->isLocked())
                        <button type="submit" class="mt-3 btn btn-primary">Update Role</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection