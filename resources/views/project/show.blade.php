@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1>{{ __('projects.Project') }} - {{ $project->title }}</h1>
        <p>
            {{ __('projects.Created by') }}
            <a href="{{ route('profile.show', ['user' => $project->creator->id]) }}">{{ $project->creator->name }}</a>
            {{ __('projects.At') }} {{ $project->created_at }}
        </p>

        <div>
            @can('update', $project)
                {{-- Edit Project Button --}}
                <a class="btn btn-warning"
                   href="{{ route('project.edit', ['project' => $project->id]) }}">{{ __('common.button.Edit') }}</a>
            @endcan

            @can('delete', $project)
                {{-- Delete Project Button --}}
                <a class="btn btn-danger"
                   onclick="event.preventDefault();
                                   document.getElementById('project-delete-form').submit();"
                   href="{{ route('project.destroy', ['project' => $project->id]) }}">{{ __('common.button.Delete') }}</a>

                {{-- Delete Project Hidden Form --}}
                <form id="project-delete-form"
                      method="post"
                      action="{{ route('project.destroy', ['project' => $project->id]) }}"
                      style="display: none;">
                    @csrf
                    {{ method_field('DELETE') }}
                </form>
            @endcan
        </div>
        <hr>

        <div class="row">
            <div class="col-md-2">
                <h2>{{ __('projects.Description') }}</h2>
                @if(!empty($project->description))
                    <p>{{ $project->description }}</p>
                @else
                    <p>{{ __('projects.message.no_description') }}</p>
                @endif
            </div>

            <div class="col-md-10">
                <h2>{{ __('projects.Tasks') }}</h2>

                @include('task._index', ['tasks' => $project->tasks()->paginate(25)])

                @can('create', [\App\Task::class, $project])
                    <a class="btn btn-primary"
                       href="{{ route('project.task.create', ['project' => $project->id]) }}">
                        {{ __('projects.button.add_task') }}
                    </a>
                @endcan
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-10 offset-md-2">
                <h2>{{ __('projects.Images') }}</h2>

                <div class="row">
                    @foreach($project->images as $image)
                        <div class="col-md-3">
                            <img src="{{ route('image.show', ['image' => $image->file]) }}" height="250">

                            {{-- Delete Image --}}
                            <form method="post" action="{{ route('image.destroy', ['image' => $image->file]) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger" type="submit">{{ __('common.button.Delete') }}</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                @can('update', $project)
                    {{-- Upload Image --}}
                    <form method="post"
                          action="{{ route('project.image.store', ['project' => $project->id]) }}"
                          enctype=multipart/form-data
                    >
                        @csrf

                        <div class="form-group">
                            <input name="image" class="form-control-file" type="file">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ __('projects.button.upload_image') }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-6 offset-md-2">
                {{-- Comments index --}}
                @include('comment._index')

                {{-- Add Comment Form --}}
                @can('create', [\App\Comment::class, $project])
                    @include('comment._form', [
                        'route' => route('project.comment.store', ['project' => $project->id])
                    ])
                @endcan

            </div>
        </div>
    </div>
@endsection