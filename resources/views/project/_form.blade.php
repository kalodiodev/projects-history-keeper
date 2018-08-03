@csrf

{{-- Project Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

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
    <label for="description" class="col-sm-2 col-form-label text-md-right">Description</label>

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
    <label for="tags" class="col-sm-2 col-form-label text-md-right">Tags</label>

    <div class="col-md-8">
        <select multiple class="form-control" id="tags" name="tags[]">
            <option value="tmp">Temporary</option>
        </select>
    </div>
</div>