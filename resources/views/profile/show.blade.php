@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Profile</h1>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <img style="border-radius: 50%; height: 250px; width: 250px;" src="{{ $user->avatar }}">
            </div>
            <div class="col-md-8">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->slogan }}</p>

                <h3>Bio</h3>
                @if(!empty($user->bio))
                    <p>{{ $user->bio }}</p>
                @else
                    <p>No info provided</p>
                @endif
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-12">
                <h3>Latest Projects</h3>
                <hr>
                @if((auth()->user()->can('view_all', \App\Project::class)) || (auth()->user()->id == $user->id))
                    @if ($user->projects()->count() > 0)
                        <ul>
                            @foreach($user->projects()->latest()->limit(10)->get() as $project)
                                <li>
                                    <a href="{{ route('project.show', ['project' => $project->id]) }}">
                                        <strong style="font-size: x-large">{{ $project->title }}</strong>
                                    </a>
                                    <p>{{ $project->description }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>User has no projects</p>
                    @endif
                @else
                    <p>You are not authorized to view user's projects</p>
                @endif
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-12">
                <h3>Latest Guides</h3>
                <hr>
                @if((auth()->user()->can('view_all', \App\Guide::class)) || (auth()->user()->id == $user->id))
                    @if ($user->guides()->count() > 0)
                        <ul>
                            @foreach($user->guides()->latest()->limit(10)->get() as $guide)
                                <li>
                                    <a href="{{ route('guide.show', ['guide' => $guide->id]) }}">
                                        <strong style="font-size: x-large">{{ $guide->title }}</strong>
                                    </a>
                                    <p>{{ $guide->description }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>User has no guides</p>
                    @endif
                @else
                    <p>You are not authorized to view user's guides</p>
                @endif
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-12">
                <h3>Latest Snippets</h3>
                <hr>
                @if((auth()->user()->can('view_all', \App\Guide::class)) || (auth()->user()->id == $user->id))
                    @if ($user->snippets()->count() > 0)
                        <ul>
                            @foreach($user->snippets()->latest()->limit(10)->get() as $snippet)
                                <li>
                                    <a href="{{ route('snippet.show', ['snippet' => $snippet->id]) }}">
                                        <strong style="font-size: x-large">{{ $snippet->title }}</strong>
                                    </a>
                                    <p>{{ $snippet->description }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>User has no snippets</p>
                    @endif
                @else
                    <p>You are not authorized to view user's snippets</p>
                @endif
            </div>
        </div>

    </div>
@endsection