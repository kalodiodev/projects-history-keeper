@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1>Projects</h1>
        <p>All projects available</p>
        <hr>

        <div class="row">
            @include('tag._index', ['taggable' => 'project'])

            <div class="col-md-10">
                <h3>Projects</h3>
                @include('partials.searchbar')

                <div class="table-container">
                    <table class="table">
                        @foreach($projects as $project)
                            <tr>
                                <td>
                                    Created By:<br>
                                    <a href="{{ route('profile.show', ['user' => $project->creator->id]) }}">
                                        {{ $project->creator->name }}
                                    </a>
                                </td>
                                <td>
                                    <div style="font-weight: 600">
                                        <a href="{{ route('project.show', ['project' => $project->id]) }}">
                                            {{ $project->title }}
                                        </a>
                                    </div>
                                    <div style="padding-top: 10px;">{{ $project->description }}</div>
                                    <div style="padding-top: 10px;">
                                        @foreach($project->tags as $tag)
                                            <span class="badge badge-primary">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td style="color: {{ $project->status->color }};">{{ $project->status->title }}</td>
                                <td>{{ $project->created_at }}</td>
                            </tr>
                        @endforeach
                    </table>

                    @if($projects->count() == 0)
                        <p class="text-center">No projects available</p>
                    @endif

                    <div class="row justify-content-center mt-3">
                        {{ $projects->appends(request()->except('page'))->links() }}
                    </div>

                    @can('create', \App\Project::class)
                        <a href="{{ route('project.create') }}" class="btn btn-primary">Add Project</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection