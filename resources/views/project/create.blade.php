@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Project</div>

                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf

                            {{-- Project Title --}}
                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

                                <div class="col-md-8">
                                    <input id="title"
                                           type="text"
                                           class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           name="title"
                                           value="{{ old('title') }}"
                                           required
                                           autofocus>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Project Description --}}
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-md-right">Description</label>

                                <div class="col-md-8">
                                    <input id="description"
                                           type="text"
                                           class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                           name="description"
                                           value="{{ old('description') }}"
                                           required
                                           autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Project Tag --}}
                            <div class="form-group row">
                                <label for="tags" class="col-sm-2 col-form-label text-md-right">Tags</label>

                                <div class="col-md-8">
                                    <select multiple class="form-control" id="tags" name="tags[]">
                                        <option value="tmp">Temporary</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-2 text-right">
                                    <button type="submit" class="btn btn-primary">Save Project</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection