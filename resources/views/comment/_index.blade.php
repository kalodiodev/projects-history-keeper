<h2>Comments</h2>

@foreach($comments as $comment)
    <div class="card mb-3">
        <div class="card-header">
            <a href="{{ route('profile.show', ['user' => $comment->creator->id]) }}">
                <strong>{{ $comment->creator->email }}</strong>
            </a> commented at: {{ $comment->created_at }}
        </div>
        <div class="card-body">
            <div>{{ $comment->comment }}</div>

            @can('delete', $comment)
                <div class="text-right">
                    {{-- Delete Comment --}}
                    <form method="post" action="{{ route('comment.destroy', ['comment' => $comment->id]) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            @endcan
        </div>
    </div>
@endforeach

@if($comments->count() == 0)
    <p class="text-center">No comments available</p>
@endif

{{-- Comments Pagination --}}
<div class="row justify-content-center mt-3">
    {{ $comments->links() }}
</div>