@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Task of Project: "{{ $task->project->title }}"</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('project.task.update', ['task' => $task->id]) }}">
                            @method('PATCH')
                            @include('task._form')

                            {{-- Buttons --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-2 text-right">
                                    <button type="submit" class="btn btn-primary">Update Task</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection