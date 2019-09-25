@extends('auth.auth')

@section('content')
    <div class="card">
        <div class="card-body text-center">
            <form method="POST" action="{{ route('login') }}">
            <div class="mb-4">
                <i class="feather icon-check-square auth-icon"></i>
            </div>
            <h3 class="mb-4">Iniciar sesión</h3>
            <div class="input-group mb-3">
                <input type="text" name="email" value="{{ old('email') }}"  class="form-control" placeholder="Email">
                 @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="input-group mb-4">
                <input type="password" name="password" class="form-control" placeholder="Contraseña">
            </div>
            <div class="form-group text-left">
                <div class="checkbox checkbox-fill d-inline">
                    <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                    <label for="checkbox-fill-a1" class="cr"> Mantenerme conectado</label>
                </div>
            </div>
            <button class="btn btn-primary shadow-2 mb-4" type="submit">Iniciar sesión</button>
            <p class="mb-2 text-muted">Olvidaste tu contraseña? <a href="auth-reset-password.html">Resetear</a></p>
            <p class="mb-0 text-muted">No tieens una cuenta? <a href="auth-signup.html">Registrarme</a></p>
            {{ csrf_field() }}
            </form>
            
        </div>
    </div>
@endsection