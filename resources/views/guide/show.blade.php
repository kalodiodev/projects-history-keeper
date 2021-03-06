@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Guide</h1>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">{{ $guide->title }}</div>

                    <div class="card-body">

                        @if($guide->hasFeaturedImage())
                            <img src="{{ $guide->featured_image }}"/>
                        @endif

                        <p>{{ $guide->description }}</p>

                        <h4>Guide Content</h4>
                        <p>{{ $guide->body }}</p>

                        <div class="text-right">
                            {{-- Edit Guide Button --}}
                            <a class="btn btn-warning"
                               href="{{ route('guide.edit', ['guide' => $guide->id]) }}">Edit</a>

                            {{-- Delete guide Button --}}
                            <a class="btn btn-danger"
                               onclick="event.preventDefault();
                               document.getElementById('guide-delete-form').submit();"
                               href="{{ route('guide.destroy', ['guide' => $guide->id]) }}">Delete</a>

                            {{-- Delete guide Hidden Form --}}
                            <form id="guide-delete-form"
                                  method="post"
                                  action="{{ route('guide.destroy', ['guide' => $guide->id]) }}"
                                  style="display: none;">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        </div>

                        <h4>Images</h4>
                        <hr>

                        <div class="row">
                            @foreach($guide->images as $image)
                                <div class="col-md-3">
                                    <img src="{{ route('image.show', ['image' => $image->file]) }}" height="250">

                                    {{-- Delete Image --}}
                                    <form method="post" action="{{ route('image.destroy', ['image' => $image->file]) }}">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        @can('update', $guide)
                            {{-- Upload Image --}}
                            <form method="post"
                                  action="{{ route('guide.image.store', ['guide' => $guide->id]) }}"
                                  enctype=multipart/form-data
                            >
                                @csrf

                                <div class="form-group">
                                    <input name="image"
                                           class="form-control-file{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                           type="file"
                                    >
                                    @if ($errors->has('image'))
                                        <ul class="invalid-feedback">
                                            @foreach($errors->all() as $error)
                                                <li><strong>{{ $error }}</strong></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Upload Image</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-12">
                {{-- Comments index --}}
                @include('comment._index')

                {{-- Add Comment Form --}}
                @can('create', [\App\Comment::class, $guide])
                    @include('comment._form', [
                        'route' => route('guide.comment.store', ['guide' => $guide->id])
                    ])
                @endcan
            </div>
        </div>
    </div>
@endsection