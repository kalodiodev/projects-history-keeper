@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Snippet</h1>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">{{ $snippet->title }}</div>

                    <div class="card-body">
                        <p>{{ $snippet->description }}</p>

                        <h4>Code</h4>
                        <p>{{ $snippet->code }}</p>

                        <div class="text-right">
                            {{-- Edit Snippet Button --}}
                            <a class="btn btn-warning"
                               href="{{ route('snippet.edit', ['snippet' => $snippet->id]) }}">Edit</a>

                            {{-- Delete Snippet Button --}}
                            <a class="btn btn-danger"
                               onclick="event.preventDefault();
                               document.getElementById('snippet-delete-form').submit();"
                               href="{{ route('snippet.destroy', ['snippet' => $snippet->id]) }}">Delete</a>

                            {{-- Delete Snippet Hidden Form --}}
                            <form id="snippet-delete-form"
                                  method="post"
                                  action="{{ route('snippet.destroy', ['snippet' => $snippet->id]) }}"
                                  style="display: none;">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection