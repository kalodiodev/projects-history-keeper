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
                        <p>{{ $guide->description }}</p>

                        <h4>Guide Content</h4>
                        <p>{{ $guide->body }}</p>

                        <div class="text-right">
                            {{-- Edit Guide Button --}}
                            <a class="btn btn-warning"
                               href="{{ route('guide.edit', ['guide' => $guide->id]) }}">Edit</a>

                            {{-- Delete Guide Button --}}
                            <a class="btn btn-danger" href="">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection