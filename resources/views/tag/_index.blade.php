<div class="col-md-2">
    <h3>Tags</h3>

    <div class="nav flex-column nav-pills">
        @foreach($tags as $tag)
            <a class="nav-link {{ isset($active_tag) && $tag->name === $active_tag ? 'active' : '' }}"
               href="{{ route( $taggable . '.index', ['tag' => $tag->name]) }}"
            >{{ $tag->name }}</a>
        @endforeach
    </div>
</div>