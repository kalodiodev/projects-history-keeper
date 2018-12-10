@csrf

{{-- Guide Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

    <div class="col-md-8">
        <input id="title"
               type="text"
               class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}"
               name="title"
               value="@if(isset($guide)){{ old('title', $guide->title) }}@else{{ old('title')}}@endif"
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
               value="@if(isset($guide)){{ old('description', $guide->description) }}@else{{ old('description')}}@endif"
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
                required
        >@if(isset($guide)){{ old('body', $guide->body) }}@else{{ old('body')}}@endif</textarea>

        @if ($errors->has('body'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Guide Featured Image --}}
<div class="form-group row">
    <label for="featured_image" class="col-sm-2 col-form-label text-md-right">Featured Image</label>

    <div class="col-md-8">
        <input id="featured_image"
               type="file"
               class="form-control-file{{ $errors->has('featured_image') ? ' is-invalid' : '' }}"
               name="featured_image"
               value="@if(isset($guide)){{ old('featured_image', $guide->file) }}@else{{ old('featured_image')}}@endif">

        @if ($errors->has('featured_image'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('featured_image') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Clear Guide Featured Image --}}
@if(isset($guide) && $guide->hasFeaturedImage())
<div class="form-group form-check row">
    <div class="col-md-8 offset-md-2">
        <input id="clear_featured_image"
               type="checkbox"
               class="form-check-input"
               name="clear_featured_image">

        <label class="form-check-label">Remove current Featured Image</label>
    </div>
</div>
@endif

{{-- Guide Tags --}}
<div class="form-group row">
    <label for="tags" class="col-sm-2 col-form-label text-md-right">Tags</label>

    <div class="col-md-8">
        <select multiple class="form-control" id="tags" name="tags[]">
            @foreach($tags as $tag)
                <option
                        @if((isset($guide)) && ($guide->hasTag($tag)))
                        selected
                        @endif
                        value="{{ $tag->id }}">
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>