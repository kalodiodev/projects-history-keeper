<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    {{-- Projects --}}
                    @can('index', App\Project::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('project.index') }}">Projects</a>
                    </li>
                    @endcan

                    {{-- Guides --}}
                    @can('index', App\Guide::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guide.index') }}">Guides</a>
                    </li>
                    @endcan

                    {{-- Snippets --}}
                    @can('index', App\Snippet::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('snippet.index') }}">Snippets</a>
                    </li>
                    @endcan
                @endauth
                @can('manage', App\User::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">Users</a>
                    </li>
                @endcan
                @can('view', App\Role::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('role.index') }}">Roles</a>
                    </li>
                @endcan
                @can('manage', App\Tag::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tag.index') }}">Tags</a>
                    </li>
                @endcan
                @can('manage', App\Status::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('status.index') }}">Statuses</a>
                    </li>
                @endcan
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <span>
                                @if(Auth::user()->hasAvatar())
                                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="avatar">
                                @else
                                    <img src="{{ asset('images/person.png') }}" alt="avatar" class="avatar">
                                @endif
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>