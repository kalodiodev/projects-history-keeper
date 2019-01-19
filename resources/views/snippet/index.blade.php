@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            @include('tag._index', ['taggable' => 'snippet'])

            <div class="col-md-10">
                <h1>Snippets</h1>
                @include('partials.searchbar')
                <hr>

                @forelse($snippets as $snippet)
                    <div>
                        <h3>{{ $snippet->title }}</h3>
                        <p>{{ $snippet->description }}</p>
                        <div class="text-right mt-5">
                            <a class="btn btn-primary"
                               href="{{ route('snippet.show', ['snippet' => $snippet->id]) }}"
                            >Read More ...</a>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No snippets available</p>
                @endforelse

                <div class="row justify-content-center mt-3">
                    {{ $snippets->appends(request()->except('page'))->links() }}
                </div>

                @can('create', \App\Snippet::class)
                    <div class="text-right mt-5">
                        <a href="{{ route('snippet.create') }}" class="btn btn-primary">Add Snippet</a>
                    </div>
                @endcan
            </div>

        </div>
    </div>
@endsection