@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Edit Profile</h1>
        <hr>

        <h3>{{ $user->name }}</h3>

        <div class="row">
            <div class="col-sm-2">
                @if($user->hasAvatar())
                    <img src="{{  $user->avatar }}" height="300" width="300"/>
                @endif
            </div>

            <div class="col-md-8">
                {{-- Update Avatar --}}
                <form method="post" action="{{ route('avatar.update') }}" enctype=multipart/form-data>
                    @csrf
                    {{ method_field('PATCH') }}

                    {{-- Avatar --}}
                    <div class="form-group row">
                        <label for="avatar" class="col-sm-2 col-form-label text-md-right">Avatar</label>

                        <div class="col-md-8">
                            <input id="avatar"
                                   class="form-control-file{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                                   type="file"
                                   name="avatar">

                            @if ($errors->has('avatar'))
                            <span class="invalid-feedback" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li><strong>{{ $error }}</strong></li>
                                    @endforeach
                                </ul>
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-2 text-right">
                            <button type="submit" class="btn btn-primary">Update Avatar</button>
                        </div>
                    </div>
                </form>

                @if($user->hasAvatar())
                    {{-- Remove Avatar --}}
                    <form method="post" action="{{ route('avatar.destroy') }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2 text-right">
                                <button type="submit" class="btn btn-primary">Remove Avatar</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    {{ method_field('PATCH') }}

                    {{-- Name --}}
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label text-md-right">Name</label>

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

                    {{-- Email --}}
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label text-md-right">Email</label>

                        <div class="col-md-8">
                            <input id="email"
                                   type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email"
                                   value="@if(isset($user)){{ old('email', $user->email) }}@else{{ old('email')}}@endif"
                                   required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    {{-- Slogan --}}
                    <div class="form-group row">
                        <label for="slogan" class="col-sm-2 col-form-label text-md-right">Slogan</label>

                        <div class="col-md-8">
                            <input id="slogan"
                                   type="text"
                                   class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}"
                                   name="slogan"
                                   value="@if(isset($user)){{ old('slogan', $user->slogan) }}@else{{ old('slogan')}}@endif">

                            @if ($errors->has('slogan'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('slogan') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div class="form-group row">
                        <label for="bio" class="col-sm-2 col-form-label text-md-right">Bio</label>

                        <div class="col-md-8">
                    <textarea id="bio"
                              name="bio"
                              class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}"
                    >@if(isset($user)){{ old('bio', $user->bio) }}@else{{ old('bio')}}@endif</textarea>

                            @if ($errors->has('bio'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bio') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-2 text-right">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection