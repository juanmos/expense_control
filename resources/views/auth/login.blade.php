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
                                <form method="POST" action="{{ route('login') }}">
                                <div class="mb-4">
                                    <i class="feather icon-check-square auth-icon"></i>
                                </div>
                                <h3 class="mb-4">Iniciar sesión</h3>
                                <div class="input-group mb-3">
                                    <input type="text" name="email" value="{{ old('email') }}"  class="single-input" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group mb-4">
                                    <input type="password" name="password" class="single-input" placeholder="Contraseña">
                                </div>
                                <div class="switch-wrap d-flex">
                                    
                                    <div class="primary-checkbox">
                                        <input type="checkbox" name="remember" id="primary-checkbox" checked="">
                                        <label for="primary-checkbox"></label>
                                    </div>
                                    <label>Mantenerme conectado</label>
                                </div>
                                <button class="genric-btn primary radius" type="submit">Iniciar sesión</button>
                                <p class="mb-2 text-muted pr-0">Olvidaste tu contraseña? <a href="{{route('password.request')}}">Resetear</a></p>
                                <p class="mb-0 text-muted pr-0">No tienes una cuenta? <a href="{{route('register')}}">Registrarme</a></p>
                                {{ csrf_field() }}
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- banner part start-->
    
@endsection