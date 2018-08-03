@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Projects</h1>
        <p>All projects available</p>
        <hr>

        @foreach($projects->chunk(2) as $projects_group)
            <div class="row">
                <div class="col-md-12">
                    <div class="card-deck">
                        @foreach($projects_group as $project)
                        <div class="card mb-3">
                            <div class="card-header">
                                {{ $project->title }}
                            </div>

                            <div class="card-body">
                                <p>{{ $project->description }}</p>

                                <table>
                                    <tr><th>Created By:</th><td>{{ $project->creator->name }}</td></tr>
                                    <tr><th>Created At:</th><td>{{ $project->created_at }}</td></tr>
                                </table>

                                <div class="text-right mt-5">
                                    <a href="" class="btn btn-primary">Open</a>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <strong>Status: </strong> Active
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="row justify-content-center mt-3">
            {{ $projects->links() }}
        </div>
    </div>
@endsection