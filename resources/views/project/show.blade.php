@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1>Project - {{ $project->title }}</h1>
        <p>
            Created By
            <a href="{{ route('profile.show', ['user' => $project->creator->id]) }}">{{ $project->creator->name }}</a>
            At {{ $project->created_at }}
        </p>

        <div>
            {{-- Edit Project Button --}}
            <a class="btn btn-warning"
               href="{{ route('project.edit', ['project' => $project->id]) }}">Edit</a>

            {{-- Delete Project Button --}}
            <a class="btn btn-danger"
               onclick="event.preventDefault();
                               document.getElementById('project-delete-form').submit();"
               href="{{ route('project.destroy', ['project' => $project->id]) }}">Delete</a>

            {{-- Delete Project Hidden Form --}}
            <form id="project-delete-form"
                  method="post"
                  action="{{ route('project.destroy', ['project' => $project->id]) }}"
                  style="display: none;">
                @csrf
                {{ method_field('DELETE') }}
            </form>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <h2>Description</h2>
                @if(!empty($project->description))
                    <p>{{ $project->description }}</p>
                @else
                    <p>Project has no description</p>
                @endif
            </div>

            <div class="col-md-10">
                <h2>Tasks</h2>

                @include('task._index', ['tasks' => $project->tasks()->paginate(25)])

                <a class="btn btn-primary" href="{{ route('project.task.create', ['project' => $project->id]) }}">Add Task</a>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-10 offset-md-2">
                <h2>Images</h2>

                <form method="post"
                      action="{{ route('project.image.store', ['project' => $project->id]) }}"
                      enctype=multipart/form-data
                >
                    @csrf

                    <div class="form-group">
                        <input name="image" class="form-control-file" type="file">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Image</button>
                </form>
            </div>
        </div>

    </div>
@endsection