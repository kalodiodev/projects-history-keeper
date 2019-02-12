@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>{{ __('users.title.index') }}</h1>
        <p>{{ __('users.subtitle.index') }}</p>

        <table class="table table-responsive-sm">
            <thead>
            <tr>
                <td>{{ __('common.ID') }}</td>
                <td>{{ __('common.Email') }}</td>
                <td>{{ __('common.Name') }}</td>
                <td>{{ __('common.Actions') }}</td>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @can('edit', \App\User::class)
                            <a class="btn btn-warning" href="{{ route('user.edit', ['user' => $user->id]) }}">
                                {{ __('common.button.Edit') }}
                            </a>
                        @endcan

                        @can('delete', \App\User::class)
                            {{-- Delete User Button --}}
                            <a class="btn btn-danger"
                               onclick="event.preventDefault();
                                       document.getElementById('user-delete-form-{{ $user->id }}').submit();"
                               href="{{ route('user.destroy', ['user' => $user->id]) }}">
                                {{ __('common.button.Delete') }}
                            </a>

                            {{-- Delete User Hidden Form --}}
                            <form id="user-delete-form-{{ $user->id }}"
                                  method="post"
                                  action="{{ route('user.destroy', ['user' => $user->id]) }}"
                                  style="display: none;">
                                @csrf
                                {{ method_field('DELETE') }}
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center mt-3">
            {{ $users->links() }}
        </div>

        <div class="text-right mt-5">
            <a href="{{ route('invitation.create') }}" class="btn btn-primary">{{ __('users.button.invite') }}</a>
        </div>
    </div>
@endsection