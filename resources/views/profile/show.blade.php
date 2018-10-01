@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Profile of user {{ $user->name }}</h1>
        <hr>

        <div class="row">
            <div class="col-md-12">
                {{-- TODO: Show Avatar --}}

                <p>{{ $user->slogan }}</p>

                <h4>Bio</h4>
                <p>{{ $user->bio }}</p>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {{-- TODO: Show User latest comments, Projects, Guides and Snippets --}}
            </div>
        </div>
    </div>
@endsection