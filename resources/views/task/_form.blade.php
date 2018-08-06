@csrf

{{-- Task Title --}}
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label text-md-right">Title</label>

    <div class="col-md-8">
        <input id="title"
               type="text"
               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
               name="title"
               value="@if(isset($task)){{ old('title', $task->title) }}@else{{ old('title')}}@endif"
               required
               autofocus>

        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Task Description --}}
<div class="form-group row">
    <label for="description" class="col-sm-2 col-form-label text-md-right">Description</label>

    <div class="col-md-8">
        <input id="description"
               type="text"
               class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
               name="description"
               value="@if(isset($task)){{ old('description', $task->description) }}@else{{ old('description')}}@endif"
               required
               autofocus>

        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Task Date--}}
<div class="form-group row">
    <label for="date" class="col-sm-2 col-form-label text-md-right">Date</label>

    <div class="col-md-8">
        <input id="date"
               type="datetime"
               class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
               name="date"
               value="@if(isset($task)){{ old('date', $task->date) }}@else{{ old('date')}}@endif"
               required
               autofocus>

        @if ($errors->has('date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('date') }}</strong>
            </span>
        @endif
    </div>
</div>

{{-- Task Details --}}
<div class="form-group row">
    <label for="details" class="col-sm-2 col-form-label text-md-right">Details</label>

    <div class="col-md-8">
        <textarea id="details" name="details" rows="7" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}"
            >@if(isset($task)){{ old('details', $task->details) }}@else{{ old('details')}}@endif
        </textarea>

        @if ($errors->has('details'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('details') }}</strong>
            </span>
        @endif
    </div>
</div>