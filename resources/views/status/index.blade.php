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
                </tr>
            </thead>

            <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <td>{{ $status->title }}</td>
                        <td style="background-color: {{ $status->color }};">{{ $status->color }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center mt-3">
            {{ $statuses->links() }}
        </div>
    </div>
@endsection