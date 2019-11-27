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
                                    @if($cliente!=null)
                                    <h5 class="m-b-10">Editar cliente</h5>
                                    @else
                                    <h5 class="m-b-10">Nueva cliente</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('naturales.clientes.index',$institucion_id)}}">Clientes</a></li>
                                    @if($cliente!=null)
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                    @else
                                    <li class="breadcrumb-item"><a href="javascript:">Nueva</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{($cliente!=null)?route('naturales.clientes.update',[$institucion_id,$cliente->id]):route('naturales.clientes.store',$institucion_id)}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($cliente!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la cliente</h5>
                                    </div>
                                    <div class="card-body">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-md-12 ">
                                                <label for="ruc">RUC / Cedula *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->cliente->ruc}}@else{{old('ruc')}}@endif" @if($cliente!=null)readonly="readonly" @endif id="ruc" name="ruc" class="form-control" required="required" aria-describedby="emailHelp" placeholder="RUC / Cedula del cliente">
                                                <label id="ruc-error" style="display:none"></label>
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Nombre persona de contacto *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->nombre}}@else{{old('nombre')}}@endif" name="nombre" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Nombre de cliente">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Apellido persona de contacto</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->apellido}}@else{{old('apellido')}}@endif" name="apellido" class="form-control" aria-describedby="emailHelp" placeholder="Apellido de cliente">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Razón Social *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->cliente->razon_social}}@else{{old('razon_social')}}@endif" name="razon_social" required="required" class="form-control" id="exampleInputPassword1" placeholder="Razón social">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Nombre comercial *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->cliente->nombre_comercial}}@else{{old('nombre_comercial')}}@endif" name="nombre_comercial" required="required" class="form-control" id="exampleInputPassword1" placeholder="Nombre comercial">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->email}}@else{{old('email')}}@endif" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Teléfono *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->cliente->telefono}}@else{{old('telefono')}}@endif" name="telefono" required="required" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Dirección *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->cliente->direccion}}@else{{old('direccion')}}@endif" name="direccion" required="required" class="form-control" id="exampleInputPassword1" placeholder="Dirección">
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                
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
