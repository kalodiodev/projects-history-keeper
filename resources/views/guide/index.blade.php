@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Guides</h1>
        <hr>

        @foreach($guides as $guide)
            <div>
                <h3>{{ $guide->title }}</h3>
                <p>{{ $guide->description }}</p>
                <div class="text-right mt-5"><a class="btn btn-primary" href="#">Read More ...</a></div>
            </div>
        @endforeach

        <div class="row justify-content-center mt-3">
            {{ $guides->links() }}
        </div>
    </div>
@endsection