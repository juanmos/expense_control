@extends('web.layout')

@section('content')
<!-- banner part start-->
<section class="banner_part">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 offset-2">
                <div class="banner_text">
                    <div class="banner_text_iner">
                        <div class="card">
                            <div class="card-body text-center">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="mb-4">
                                        <i class="feather icon-user-plus auth-icon"></i>
                                    </div>
                                    <h3 class="mb-4">Crear una nueva cuenta</h3>
                                    <div class="input-group mb-3">
                                        <input type="text" class="single-input{{ $errors->has('nombre') ? ' is-invalid' : '' }}" placeholder="Nombre" name="nombre" value="{{ old('nombre') }}" required autofocus>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="single-input{{ $errors->has('apellido') ? ' is-invalid' : '' }}" placeholder="Apellido" name="apellido" value="{{ old('apellido') }}" required autofocus>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="single-input{{ $errors->has('telefono') ? ' is-invalid' : '' }}" placeholder="Teléfono" name="telefono" value="{{ old('telefono') }}" required autofocus>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="email" class="single-input{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <input type="password" class="single-input{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Contraseña" name="password" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <input type="password" class="single-input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Re ingrese la contraseña" name="password_confirmation" required>
                                    </div>
                                    <button class="genric-btn primary radius shadow-2 mb-4">Crear cuenta</button>
                                    <p class="mb-0 text-muted pr-0">Ya tienes una cuenta? <a href="{{route('login')}}"> Iniciar sesión</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

@endsection
