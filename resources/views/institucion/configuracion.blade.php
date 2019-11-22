@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            @include('includes.mensaje')
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
                                                     --}}
                                                    <li class="nav-item">
                                                        <a class="nav-link active show" id="facturacion-tab" data-toggle="tab" href="#facturacion" role="tab" aria-controls="facturacion" aria-selected="false">Facturacion</a>
                                                    </li>
                                                    
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade active show" id="facturacion" role="tabpanel" aria-labelledby="facturacion-tab">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Razón social</label>
                                                                {!! Form::text('razon_social', ($configuracion->configuraciones!=null && array_key_exists('razon_social',$configuracion->configuraciones))?$configuracion->configuraciones['razon_social'] : $institucion->nombre ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Nombre comercial</label>
                                                                {!! Form::text('nombre_comercial', ($configuracion->configuraciones!=null && array_key_exists('nombre_comercial',$configuracion->configuraciones))?$configuracion->configuraciones['nombre_comercial'] : $institucion->nombre ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">RUC</label>
                                                                {!! Form::text('ruc', ($configuracion->configuraciones!=null && array_key_exists('ruc',$configuracion->configuraciones))?$configuracion->configuraciones['ruc'] : $institucion->ruc ,["class"=>"form-control","placeholder"=>'RUC']) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Email facturacion</label>
                                                                {!! Form::text('email_facturacion', ($configuracion->configuraciones!=null && array_key_exists('email_facturacion',$configuracion->configuraciones))?$configuracion->configuraciones['email_facturacion'] : $institucion->email ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Lleva contabilidad</label>
                                                                {!! Form::select('contabilidad',['SI'=>'SI','NO'=>'NO'], ($configuracion->configuraciones!=null && array_key_exists('contabilidad',$configuracion->configuraciones))?$configuracion->configuraciones['contabilidad'] : 'NO' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Dirección de facturación</label>
                                                                {!! Form::text('direccion_facturacion', ($configuracion->configuraciones!=null && array_key_exists('direccion_facturacion',$configuracion->configuraciones))?$configuracion->configuraciones['direccion_facturacion'] : $institucion->direccion ,["class"=>"form-control"]) !!}
                                                            </div>
                                                             <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Teléfono de facturación</label>
                                                                {!! Form::text('telefono_facturacion', ($configuracion->configuraciones!=null && array_key_exists('telefono_facturacion',$configuracion->configuraciones))?$configuracion->configuraciones['telefono_facturacion'] : $institucion->telefono ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Establecimiento</label>
                                                                {!! Form::text('establecimiento', ($configuracion->configuraciones!=null && array_key_exists('establecimiento',$configuracion->configuraciones))?$configuracion->configuraciones['establecimiento'] : '001' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Punto</label>
                                                                {!! Form::text('punto', ($configuracion->configuraciones!=null && array_key_exists('punto',$configuracion->configuraciones))?$configuracion->configuraciones['punto'] : '500' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Secuencia</label>
                                                                {!! Form::text('secuencia', ($configuracion->configuraciones!=null && array_key_exists('secuencia',$configuracion->configuraciones))?$configuracion->configuraciones['secuencia'] : '1' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Firma electrónica: {!!($configuracion->configuraciones!=null && array_key_exists('firma',$configuracion->configuraciones))?($configuracion->configuraciones['firma'])?'<span class="label text-c-green">Firma guardada</span>':'' : ''!!}</label>
                                                                {!! Form::file('firma',["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Clave</label>
                                                                
                                                                {!! Form::password('clave',["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Fecha expiración</label>
                                                                {!! Form::text('fecha_expiracion', ($configuracion->configuraciones!=null && array_key_exists('fecha_expiracion',$configuracion->configuraciones))?$configuracion->configuraciones['fecha_expiracion'] : '' ,["class"=>"form-control","placeholder"=>'Obtendremos la fecha de expiracion de tu firma electronica']) !!}
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">En modo:</label><br>
                                                                <div class="radio d-inline">
                                                                    <input type="radio" name="ambiente_facturacion" id="radio-produccion" value="2" {{($configuracion->configuraciones!=null && array_key_exists('ambiente_facturacion',$configuracion->configuraciones))?($configuracion->configuraciones['ambiente_facturacion']==2)?'checked':'':''}}>
                                                                    <label for="radio-produccion" class="cr">Producción</label>
                                                                </div>
                                                                <div class="radio d-inline">
                                                                    <input type="radio" name="ambiente_facturacion" id="radio-pruebas" value="1" {{($configuracion->configuraciones!=null && array_key_exists('ambiente_facturacion',$configuracion->configuraciones))?($configuracion->configuraciones['ambiente_facturacion']==1)?'checked':'':''}}>
                                                                    <label for="radio-pruebas" class="cr">Pruebas</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="exampleInputPassword1">Clave SRI para obtener compras</label>
                                                                {!! Form::password('clave_sri',["class"=>"form-control"]) !!}
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