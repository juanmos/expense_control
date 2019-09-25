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
                                    <h5 class="m-b-10">Configuraciones de empresa</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresa</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{route('configuracion.update',$configuracion->id)}}" method="POST">
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
                                        <h5>Datos de configuración de la empresa</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 m-b-30">
                                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Agenda</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Usuarios</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Facturacion</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Hora inicial de agenda</label>
                                                                {!! Form::select('min_time', $horaInicial, ($configuracion!=null)?$configuracion->min_time : '06:00:00' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Hora final de agenda</label>
                                                                {!! Form::select('max_time', $horaFinal, ($configuracion!=null)?$configuracion->max_time : '19:00:00' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Vista inicial de agenda</label>
                                                                {!! Form::select('defaultView', $vistaAgenda, ($configuracion!=null)?$configuracion->defaultView : '06:00:00' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="exampleInputPassword1">Duración por defecto</label>
                                                                {!! Form::select('tiempo_visita', $tiempoVisita, ($configuracion!=null)?$configuracion->tiempo_visita : '19:00:00' ,["class"=>"form-control"]) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>User</th>
                                                                    <th>Activity</th>
                                                                    <th>Time</th>
                                                                    <th>Status</th>
                                                                    <th class="text-right"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">2:37 PM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">The quick brown fox</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">3:28 PM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">The quick brown fox</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">4:28 PM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">10:23 AM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>User</th>
                                                                    <th>Activity</th>
                                                                    <th>Time</th>
                                                                    <th>Status</th>
                                                                    <th class="text-right"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">10:23 AM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">The quick brown fox</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">3:28 PM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">2:37 PM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">The quick brown fox</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0">4:28 PM</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                                    </td>
                                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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