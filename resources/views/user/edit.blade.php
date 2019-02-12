@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>{{ __('users.title.edit') }}</h1>
        <hr>

        <form method="post" action="{{ route('user.update', ['user' => $user->id]) }}">
            @csrf
            {{ method_field('PATCH') }}

            {{-- User Name --}}
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label text-md-right">{{ __('users.form.name') }}</label>

                <div class="col-md-8">
                    <input id="name"
                           type="text"
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name"
                           value="@if(isset($user)){{ old('name', $user->name) }}@else{{ old('name')}}@endif"
                           required
                           autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- User Email --}}
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label text-md-right">{{ __('users.form.email') }}</label>

                <div class="col-md-8">
                    <input id="email"
                           type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email"
                           value="@if(isset($user)){{ old('email', $user->email) }}@else{{ old('email')}}@endif"
                           required
                           disabled
                           autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- User Role --}}
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label text-md-right">{{ __('users.form.role') }}</label>

                <div class="col-md-8">
                    <select class="form-control" id="role" name="role_id">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    @if(isset($user) && ($user->role_id == $role->id))
                                        selected
                                    @endif
                            >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-2 text-right">
                    <button type="submit" class="btn btn-primary">{{ __('users.button.update') }}</button>
                </div>
            </div>
        </form>

    </div>
@endsection