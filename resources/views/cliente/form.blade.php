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
                                    <li class="breadcrumb-item"><a href="{{route('cliente.index')}}">cliente</a></li>
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
                <form action="{{($cliente!=null)?route('cliente.update',$cliente->id):route('cliente.store')}}" method="POST">
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
                                        <div class="row">
                                            
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Cliente *</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->nombre}}@endif" name="nombre" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Cliente">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Web</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->web}}@endif" name="web" class="form-control" id="exampleInputPassword1" placeholder="Web">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Clasificación</label>
                                                {{-- <input type="text" value="@if($cliente!=null){{$cliente->activo}}@endif" name="activo" class="form-control" id="exampleInputPassword1" placeholder="Activo"> --}}
                                                {!! Form::select('clasificacion_id', $clasificacion, ($cliente!=null)?$cliente->clasificacion_id : 1 ,["class"=>"form-control"]) !!}
                                            </div>
                                            
                                            <div class="form-group col-md-{{($cliente!=null)?'6':'12'}}">
                                                <label for="exampleInputPassword1">Vendedor</label>
                                                {{-- <input type="text" value="@if($cliente!=null){{$cliente->activo}}@endif" name="activo" class="form-control" id="exampleInputPassword1" placeholder="Activo"> --}}
                                                {!! Form::select('usuario_id', $vendedores, ($cliente!=null)?$cliente->usuario_id : 1 ,["class"=>"form-control"]) !!}
                                            </div>
                                            
                                            @if($cliente!=null)
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Activo</label>
                                                {!! Form::select('activo', ["0"=>"Inactivo","1"=>"Activo"], ($cliente!=null)?$cliente->activo : 1 ,["class"=>"form-control"]) !!}
                                            </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de facturación</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @if($cliente==null)
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">País</label>
                                                {!! Form::select('pais_id', $paises, ($cliente!=null)?$oficina->pais_is : 1 ,["class"=>"form-control"]) !!}
                                            </div> 
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Ciudad</label>
                                                {!! Form::select('ciudad_id', $ciudades, ($cliente!=null)?$oficina->ciudad_id : 1 ,["class"=>"form-control"]) !!}
                                            </div> 
                                            @endif
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Dirección</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->facturacion->direccion}}@endif" name="direccion" class="form-control" placeholder="Dirección">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->facturacion->telefono_facturacion}}@endif" name="telefono_facturacion" class="form-control" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">RUC</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->facturacion->ruc}}@endif" name="ruc" class="form-control" placeholder="RUC">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="text" value="@if($cliente!=null){{$cliente->facturacion->email}}@endif" name="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($cliente==null)
                                
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del contacto</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Nombre *</label>
                                                <input type="text"  name="nombre_contacto" class="form-control" aria-describedby="emailHelp"  required="required" placeholder="Nombre">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Apellido *</label>
                                                <input type="text" name="apellido_contacto" class="form-control" id="exampleInputPassword1" required="required" placeholder="Apellido">
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="email" name="email_contacto" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Cargo</label>
                                                <input type="text" name="cargo_contacto" class="form-control" id="exampleInputPassword1" placeholder="Cargo">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" name="telefono_contacto" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Extensión</label>
                                                <input type="text" name="extension_contacto" class="form-control" id="exampleInputPassword1" placeholder="Extensión">
                                            </div> 
                                            
                                            <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                @else
                                <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                @endif
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

