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
                                    
                                    <h5 class="m-b-10">Editar institución</h5>
                                    
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('institucion.index')}}">Institución</a></li>
                                    
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{route('naturales.update',$institucion->id)}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="PUT"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la Institución</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">* Institución / Nombre</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->nombre}}@endif" name="nombre" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Institución o Nombre">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">SIGLAS / Nombre comercial</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->siglas}}@endif" name="siglas" class="form-control" id="exampleInputPassword1" placeholder="Siglas o Nombre comercial">
                                            </div>
                                            
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputPassword1">Dirección</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->direccion}}@endif" name="direccion" class="form-control" id="exampleInputPassword1" placeholder="Dirección">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">RUC</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->ruc}}@endif" name="ruc" class="form-control" id="exampleInputPassword1" placeholder="RUC">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Celular</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->celular}}@endif" name="celular" class="form-control" id="exampleInputPassword1" placeholder="Celular">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Web</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->web}}@endif" name="web" class="form-control" id="exampleInputPassword1" placeholder="Web">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->email}}@endif" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Facebook</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->facebook}}@endif" name="facebook" class="form-control" id="exampleInputPassword1" placeholder="Facebook">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Twitter</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->twitter}}@endif" name="twitter" class="form-control" id="exampleInputPassword1" placeholder="Twitter">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Instagram</label>
                                                <input type="text" value="@if($institucion!=null){{$institucion->instagram}}@endif" name="instagram" class="form-control" id="exampleInputPassword1" placeholder="Instagram">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Estado</label>
                                                {!! Form::select('estado_id', $estado, ($institucion!=null)?$institucion->estado_id:1,["class"=>"form-control"]) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">País</label>
                                                {!! Form::select('pais_id', $paises, ($institucion!=null)?($institucion->ciudad!=null)?$institucion->ciudad->pais_id:1:1,["class"=>"form-control"]) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Ciudad</label>
                                                {!! Form::select('ciudad_id', $ciudad, ($institucion!=null)?$institucion->ciudad_id:1,["class"=>"form-control"]) !!}
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

