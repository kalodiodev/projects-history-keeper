@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Project</h1>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">{{ $project->title }}</div>

                    <div class="card-body">
                        <p>{{ $project->description }}</p>

                        <h4>Details</h4>
                        <table>
                            <tbody>
                                <tr><th>Created By:</th><td>{{ $project->creator->name }}</td></tr>
                                <tr><th>Created At:</th><td>{{ $project->created_at }}</td></tr>
                                <tr><th>Last Updated At:</th><td>{{ $project->updated_at }}</td></tr>
                            </tbody>
                        </table>

                        <div class="text-right">
                            {{-- Edit Project Button --}}
                            <a class="btn btn-warning"
                               href="{{ route('project.edit', ['project' => $project->id]) }}">Edit</a>

                            {{-- Delete Project Button --}}
                            <a class="btn btn-danger"
                               onclick="event.preventDefault();
                               document.getElementById('delete-form').submit();"
                               href="{{ route('project.destroy', ['project' => $project->id]) }}">Delete</a>

                            {{-- Delete Project Hidden Form --}}
                            <form id="delete-form"
                                  method="post"
                                  action="{{ route('project.destroy', ['project' => $project->id]) }}"
                                  style="display: none;">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Tasks</h2>
            </div>
        </div>
    </div>
@endsection