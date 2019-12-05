@if (session('mensaje'))
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif

@if (session('error-mensaje'))
    <div class="alert alert-danger">
        {{ session('error-mensaje') }}
    </div>
@endif