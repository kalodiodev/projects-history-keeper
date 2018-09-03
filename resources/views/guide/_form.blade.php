@csrf

{{-- Guide Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

    <div class="col-md-8">
        <input id="title"
               type="text"
               class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}"
               name="title"
               value="{{ old('title') }}"
               required>

        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Guide Description --}}
<div class="form-group row">
    <label for="description" class="col-sm-2 col-form-label text-md-right">Description</label>

    <div class="col-md-8">
        <input id="description"
               type="text"
               class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
               name="description"
               value="{{ old('description') }}"
               required>

        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Guide Body --}}
<div class="form-group row">
    <label for="body" class="col-sm-2 col-form-label text-md-right">Body</label>

    <div class="col-md-8">
        <textarea
                id="body"
                class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                name="body"
                rows="15"
                required>{{ old('body') }}</textarea>

        @if ($errors->has('body'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Guide Tags --}}
<div class="form-group row">
    <label for="tags" class="col-sm-2 col-form-label text-md-right">Tags</label>

    <div class="col-md-8">
        <select multiple class="form-control" id="tags" name="tags[]">
            <option value="tmp">Temporary</option>
        </select>
    </div>
</div>