@csrf

{{-- Tag Name --}}
<div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label text-md-right">Name</label>

    <div class="col-md-8">
        <input id="name"
               type="text"
               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
               name="name"
               value="@if(isset($tag)){{ old('name', $tag->name) }}@else{{ old('name')}}@endif"
               required
               autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>