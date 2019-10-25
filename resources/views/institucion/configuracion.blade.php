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
                                    <h5 class="m-b-10">Configuraciones de institución</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('institucion.show',$configuracion->institucion_id)}}">Institución</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Configuraciones</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{route('institucion.configuracion.update',$configuracion->id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="PUT"/>
                    @method('PUT')
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de configuración de la institución</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 m-b-30">
                                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                                    {{-- <li class="nav-item">
                                                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Agenda</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Usuarios</a>
                                                    </li> --}}
                                                    <li class="nav-item">
                                                        <a class="nav-link active show" id="facturacion-tab" data-toggle="tab" href="#facturacion" role="tab" aria-controls="facturacion" aria-selected="false">Facturacion</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade active show" id="facturacion" role="tabpanel" aria-labelledby="facturacion-tab">
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Establecimiento</label>
                                                                {!! Form::text('establecimiento', ($configuracion->configuraciones!=null)?$configuracion->configuraciones['establecimiento'] : '001' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Punto</label>
                                                                {!! Form::text('punto', ($configuracion->configuraciones!=null)?$configuracion->configuraciones['punto'] : '500' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Secuencia</label>
                                                                {!! Form::text('secuencia', ($configuracion->configuraciones!=null)?$configuracion->configuraciones['secuencia'] : '1' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Firma electrónica: {!!($configuracion->configuraciones!=null)?($configuracion->configuraciones['firma'])?'<span class="label text-c-green">Firma guardada</span>':'' : ''!!}</label>
                                                                {!! Form::file('firma',["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Clave</label>
                                                                
                                                                {!! Form::password('clave',["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Fecha expiración</label>
                                                                {!! Form::text('fecha_expiracion', ($configuracion->configuraciones!=null)?$configuracion->configuraciones['fecha_expiracion'] : '' ,["class"=>"form-control","readonly"=>"readonly","placeholder"=>'Obtendremos la fecha de expiracion de tu firma electronica']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                       

                                                    </div>
                                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Empresa</label>
                                                <input type="text" value="@if($configuracion!=null){{$configuracion->nombre}}@endif" name="nombre" class="form-control" aria-describedby="emailHelp" placeholder="configuracion">
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">RUC</label>
                                                <input type="text" value="@if($configuracion!=null){{$configuracion->ruc}}@endif" name="ruc" class="form-control" id="exampleInputPassword1" placeholder="RUC">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Dirección</label>
                                                <input type="text" value="@if($configuracion!=null){{$configuracion->direccion}}@endif" name="direccion" class="form-control" id="exampleInputPassword1" placeholder="Dirección">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Ciudad</label>
                                                
                                                {!! Form::select('ciudad_id', $ciudad, ($configuracion!=null)?$configuracion->ciudad_id : 1 ,["class"=>"form-control"]) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($configuracion!=null){{$configuracion->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Costo</label>
                                                <input type="text" value="@if($configuracion!=null){{$configuracion->costo}}@endif" name="costo" class="form-control" id="exampleInputPassword1" placeholder="Costo">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Activo</label>
                                                
                                                {!! Form::select('activo', ["0"=>"Inactivo","1"=>"Activo"], ($configuracion!=null)?$configuracion->activo : 1 ,["class"=>"form-control"]) !!}
                                            </div> --}}
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

@if(Session::has('mensaje'))


@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $.notify("{{Session::get('mensaje')}}",{"type":"success","placement":{"align":"center"}})
    });
</script>
@endpush
@endif