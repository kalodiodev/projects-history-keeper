@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Snippets</h1>
        <hr>

        @foreach($snippets as $snippet)
            <div>
                <h3>{{ $snippet->title }}</h3>
                <p>{{ $snippet->description }}</p>
                <div class="text-right mt-5"><a class="btn btn-primary" href="#">Read More ...</a></div>
            </div>
        @endforeach

        @if($snippets->count() == 0)
            <p class="text-center">No snippets available</p>
        @endif

        <div class="row justify-content-center mt-3">
            {{ $snippets->links() }}
        </div>

        @can('create', \App\Snippet::class)
            <div class="text-right mt-5">
                <a href="{{ route('snippet.create') }}" class="btn btn-primary">Add Snippet</a>
            </div>
        @endcan
    </div>
@endsection