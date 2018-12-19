@csrf

{{-- Status Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

    <div class="col-md-8">
        <input id="title"
               type="text"
               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
               name="title"
               value="@if(isset($status)){{ old('title', $status->title) }}@else{{ old('title')}}@endif"
               required
               autofocus>

        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Status Color --}}
<div class="form-group row">
    <label for="color" class="col-sm-2 col-form-label text-md-right">Color</label>

    <div class="col-md-8">
        <input id="color"
               type="text"
               class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}"
               name="color"
               value="@if(isset($status)){{ old('color', $status->color) }}@else{{ old('color')}}@endif"
               required
               autofocus>

        @if ($errors->has('color'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('color') }}</strong>
            </span>
        @endif
    </div>
</div>