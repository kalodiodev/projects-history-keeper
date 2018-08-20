@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Tags</h1>
        <p>All tags available</p>

        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Action</td>
                </tr>
            </thead>

            <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('tag.edit', ['tag' => $tag->id]) }}">Edit</a>

                            {{-- Delete Tag Button --}}
                            <a class="btn btn-danger"
                               onclick="event.preventDefault();
                               document.getElementById('tag-delete-form').submit();"
                               href="{{ route('tag.destroy', ['tag' => $tag->id]) }}">Delete</a>

                            {{-- Delete Tag Hidden Form --}}
                            <form id="tag-delete-form"
                                  method="post"
                                  action="{{ route('tag.destroy', ['tag' => $tag->id]) }}"
                                  style="display: none;">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center mt-3">
            {{ $tags->links() }}
        </div>

        <div class="text-right mt-5">
            <a href="{{ route('tag.create') }}" class="btn btn-primary">Add Tag</a>
        </div>
    </div>
@endsection