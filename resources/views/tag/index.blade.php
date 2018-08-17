@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Tags</h1>
        <p>All tags available</p>
        <hr>

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
                            <a class="btn btn-warning" href="">Edit</a>
                            <a class="btn btn-danger" href="">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center mt-3">
            {{ $tags->links() }}
        </div>
    </div>
@endsection