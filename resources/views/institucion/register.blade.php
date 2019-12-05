@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    
                                    <h5 class="m-b-10">Datos del usuario</h5>
                                    <p>Ingresa los datos de usuario para completar el registro de tu perfil</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{route('register.institucion')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">* Razón Social</label>
                                                <input type="text" value="{{$user->full_name}}" name="nombre" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" required="required" aria-describedby="emailHelp" placeholder="Institución o Nombre">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Nombre comercial</label>
                                                <input type="text" value="" name="siglas" class="form-control" id="exampleInputPassword1" placeholder="Nombre comercial">
                                            </div>
                                            
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputPassword1">* Dirección</label>
                                                <input type="text" value="" name="direccion" class="form-control" id="exampleInputPassword1" placeholder="Dirección">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">* RUC</label>
                                                <input type="text" value="" name="ruc"  class="form-control{{ $errors->has('ruc') ? ' is-invalid' : '' }}" id="ruc" placeholder="RUC">
                                                <label id="ruc-error" style="display:none"></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="{{$user->telefono}}" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/plugins/ruc/ruc_jquery_validator.min.js')}}"></script>
<script>
    $(document).ready(function(){
        var opciones = {
            strict: true,              // va a validar siempre, aunque la cantidad de caracteres no sea 10 ni 13
            events: "change",          // evento que va a disparar la validación
            the_classes: "invalid",    // clase que se va a agregar al nodo en el que se realiza la validación
            onValid: function () {
                $('#ruc-error').html('La cedula/RUC es valida').removeClass('invalid-feedback').addClass('success-feedback').show();
            },   // callback cuando la cédula es correcta.
            onInvalid: function () {
                $('#ruc-error').html('La cedula/RUC no es valida').removeClass('success-feedback').addClass('invalid-feedback').show()
                
            }  // callback cuando la cédula es incorrecta.
        };
        $("#ruc").validarCedulaEC(opciones);
    })
</script>
@endpush
