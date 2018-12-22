@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Project Statuses</h1>
        <p>All statuses available</p>

        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <td>Title</td>
                    <td>Color</td>
                    <td>Action</td>
                </tr>
            </thead>

            <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <td>{{ $status->title }}</td>
                        <td style="background-color: {{ $status->color }};">{{ $status->color }}</td>
                        <td>
                            <a class="btn btn-warning" href="{{ route('status.edit', ['status' => $status->id]) }}">Edit</a>

                            {{-- Delete Status Button --}}
                            <a class="btn btn-danger"
                               onclick="event.preventDefault();
                                       document.getElementById('status-delete-form-{{ $status->id }}').submit();"
                               href="{{ route('status.destroy', ['status' => $status->id]) }}">Delete</a>

                            {{-- Delete Status Hidden Form --}}
                            <form id="status-delete-form-{{ $status->id }}"
                                  method="post"
                                  action="{{ route('status.destroy', ['status' => $status->id]) }}"
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
            {{ $statuses->links() }}
        </div>

        <div class="text-right mt-5">
            <a href="{{ route('status.create') }}" class="btn btn-primary">Add Status</a>
        </div>
    </div>
@endsection