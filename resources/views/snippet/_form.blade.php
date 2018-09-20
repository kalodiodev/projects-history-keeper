@csrf

{{-- Snippet Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

    <div class="col-md-8">
        <input id="title"
               type="text"
               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
               name="title"
               value="@if(isset($snippet)){{ old('title', $snippet->title) }}@else{{ old('title')}}@endif"
               required
               autofocus>

        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Snippet Description --}}
<div class="form-group row">
    <label for="description" class="col-sm-2 col-form-label text-md-right">Description</label>

    <div class="col-md-8">
        <input id="description"
               type="text"
               class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
               name="description"
               value="@if(isset($snippet)){{ old('description', $snippet->description) }}@else{{ old('description')}}@endif"
               required
               autofocus>

        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Snippet Code --}}
<div class="form-group row">
    <label for="code" class="col-sm-2 col-form-label text-md-right">Code</label>

    <div class="col-md-8">
        <textarea
                id="code"
                name="code"
                class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
        >@if(isset($snippet)){{ old('code', $snippet->code) }}@else{{ old('code')}}@endif</textarea>

        @if ($errors->has('code'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Snippet Tag --}}
<div class="form-group row">
    <label for="tags" class="col-sm-2 col-form-label text-md-right">Tags</label>

    <div class="col-md-8">
        <select multiple class="form-control" id="tags" name="tags[]">
            @foreach($tags as $tag)
                <option
                        @if((isset($snippet)) && ($snippet->hasTag($tag)))
                        selected
                        @endif
                        value="{{ $tag->id }}">
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>