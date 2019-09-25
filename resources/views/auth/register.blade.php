@extends('auth.auth')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <i class="feather icon-user-plus auth-icon"></i>
            </div>
            <h3 class="mb-4">Registrarse</h3>
            <div class="input-group mb-3">
                <input type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" name="nombre" value="{{ old('nombre') }}" required autofocus>
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" placeholder="Apellido" name="apellido" value="{{ old('apellido') }}" required autofocus>
            </div>
            <div class="input-group mb-3">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="input-group mb-4">
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" name="password" required>
            </div>
            <div class="input-group mb-4">
                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Re ingrese la contraseña" name="password_confirmation" required>
            </div>
            <button class="btn btn-primary shadow-2 mb-4">Crear cuenta</button>
            <p class="mb-0 text-muted">Ya tienes una cuenta? <a href="auth-signin.html"> Iniciar sesión</a></p>
        </form>
    </div>
</div>

@endsection
