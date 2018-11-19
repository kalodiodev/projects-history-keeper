<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->date }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    <a href="{{ route('project.task.edit', ['task' => $task->id]) }}" class="btn btn-warning">Edit</a>

                    {{-- Delete Task Button --}}
                    <a class="btn btn-danger"
                       onclick="event.preventDefault();
                               document.getElementById('task-delete-form-{{ $task->id }}').submit();"
                       href="{{ route('project.task.destroy', ['task' => $task->id]) }}">Delete</a>

                    {{-- Delete Task Hidden Form --}}
                    <form id="task-delete-form-{{ $task->id }}"
                          method="post"
                          action="{{ route('project.task.destroy', ['task' => $task->id]) }}"
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
    {{ $tasks->links() }}
</div>