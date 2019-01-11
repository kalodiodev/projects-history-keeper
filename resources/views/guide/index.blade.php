@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            @include('tag._index', ['taggable' => 'guide'])

            <div class="col-md-10">
                <h1>Guides</h1>
                <hr>

                @foreach($guides as $guide)
                    <div>
                        <h3>{{ $guide->title }}</h3>
                        <p>{{ $guide->description }}</p>
                        <div class="text-right mt-5">
                            <a class="btn btn-primary"
                               href="{{ route('guide.show', ['guide' => $guide->id])  }}">Read More ...</a>
                        </div>
                    </div>
                @endforeach

                @if($guides->count() == 0)
                    <p class="text-center">No guides available</p>
                @endif

                <div class="row justify-content-center mt-3">
                    {{ $guides->links() }}
                </div>

                @can('create', \App\Guide::class)
                    <div class="text-right mt-5">
                        <a href="{{ route('guide.create') }}" class="btn btn-primary">Add Guide</a>
                    </div>
                @endcan
            </div>

        </div>
    </div>
@endsection