@csrf

{{-- Project Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">
        {{ __('projects.form.title') }}
    </label>

    <div class="col-md-8">
        <input id="title"
               type="text"
               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
               name="title"
               value="@if(isset($project)){{ old('title', $project->title) }}@else{{ old('title')}}@endif"
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
    <label for="description" class="col-sm-2 col-form-label text-md-right">
        {{ __('projects.form.description') }}
    </label>

    <div class="col-md-8">
        <input id="description"
               type="text"
               class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
               name="description"
               value="@if(isset($project)){{ old('description', $project->description) }}@else{{ old('description')}}@endif"
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
    <label for="tags" class="col-sm-2 col-form-label text-md-right">
        {{ __('projects.form.tags') }}
    </label>

    <div class="col-md-8">
        <select multiple class="form-control" id="tags" name="tags[]">
            @foreach($tags as $tag)
                <option
                        @if((isset($project)) && ($project->hasTag($tag)))
                            selected
                        @endif
                        value="{{ $tag->id }}">
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="status" class="col-sm-2 col-form-label text-md-right">
        {{ __('projects.form.status') }}
    </label>

    <div class="col-md-8">
        <select class="form-control" id="status" name="status_id">
            @foreach($statuses as $status)
                <option
                        @if((isset($project)) && ($project->status->id == $status->id))
                            selected
                        @endif
                        value="{{ $status->id }}"
                >
                    {{ $status->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>