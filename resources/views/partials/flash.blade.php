@if($flash = session('message'))
    <div id="flash-message" class="alert alert-success" role="alert">
        {{ $flash }}
    </div>
@endif

@if($flash = session('error-message'))
    <div id="flash-error-message" class="alert alert-danger" role="alert">
        {{ $flash }}
    </div>
@endif