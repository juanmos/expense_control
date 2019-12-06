@extends('web.layout')

@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<section class="banner_part">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 offset-2">
                <div class="banner_text">
                    <div class="banner_text_iner">
                        <div class="card">
                            <div class="card-body text-center">
                                
                                <div class="mb-4">
                                    <i class="feather icon-mail auth-icon"></i>
                                </div>
                                <h3 class="mb-4">Resetear contraseña</h3>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email" class="col-md-12 col-form-label text-md-left">Email con el que te registraste</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="single-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12">
                                            <button type="submit" class="genric-btn primary radius shadow-2 mb-4">
                                                {{ __('Recuperar contraseña') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
