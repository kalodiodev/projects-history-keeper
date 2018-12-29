<div class="card">
    <div class="card-header">
        Write your comment
    </div>
    <div class="card-body">
        <form method="post" action="{{ $route }}">
            @csrf
            {{-- Comment --}}
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label text-md-right">Comment</label>

                <div class="col-md-10">
                <textarea
                    id="comment"
                    class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"
                    name="comment"
                    rows="4"
                    required>{{ old('comment') }}</textarea>

                    @if ($errors->has('comment'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{-- Buttons --}}
            <div class="form-group row mb-0">
                <div class="col-md-10 offset-md-2 text-right">
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </div>
            </div>
        </form>
    </div>
</div>