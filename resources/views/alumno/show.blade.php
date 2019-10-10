@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('institucion.show',$id)}}">Institución</a></li>
                        <li class="breadcrumb-item"><a href="{{route('institucion.alumnos',$id)}}">Alumnos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$usuario->full_name}}</li>
                    </ol>                 
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- [ statistics year chart ] start -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <img class="rounded-circle float-right" style="width:60px;" src="{{Storage::url($usuario->foto)}}" alt="activity-user">
                                                <h5 class="m-0">{{$usuario->full_name}}</h5>
                                                <sub class="text-muted f-14"><small>Email: </small>{{$usuario->email}}</sub><br>
                                                <sub class="text-muted f-14"><small>Telf: </small>{{$usuario->telefono}}</sub><br>
                                                <sub class="text-muted f-14"><small>Celular: </small>{{$usuario->celular}}</sub><br>
                                                <sub class="text-muted f-14"><small>Cedula: </small>{{$usuario->cedula}}</sub><br>
                                                <sub class="text-muted f-14"><small>Curso: </small>{{$usuario->alumno->curso}}</sub><br>
                                                <sub class="text-muted f-14"><small>Ano lectivo: </small>{{$usuario->alumno->ano_lectivo}}</sub><br>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            <a href="{{route('institucion.alumno.edit',[$id,$usuario->id])}}" class="label theme-bg text-white f-12">Editar</a> 
                                            <a href="{{route('institucion.refrigerio.crear',$usuario->id)}}" class="label theme-bg2 text-white f-12"><i class="feather icon-plus"></i> Refrigerios</a>
                                        </h6>
                                        <i class="far fa-user text-c-purple f-50"></i>
                                        
                                    </div>
                                </div>
                                <div class="card theme-bg">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h4 class="text-white">Saldo</h4>
                                            </div>
                                            <div class="col">
                                                <h2 class="text-white text-right f-w-300">${{number_format($usuario->saldo,2)}}</h2>
                                            </div>
                                        </div>
                                        <div class="m-t-50">
                                            <h6 class="text-white"><i class="feather icon-trending-up f-16 text-c-green"></i> Recargas del mes ({{$recargas->count()}}) <span class="float-right text-white">${{$recargas->sum('valor')}}</span></h6>
                                            <h6 class="text-white mt-3"><i class="feather icon-trending-down f-16 text-c-red"></i> Compras del mes ({{$compras->count()}}) <span class="float-right text-whitw">${{$compras->sum('valor')}}</span></h6>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>TARJETAS</h5>
                                        <a href="" data-toggle="modal" data-target="#tarjetaModa" class="label theme-bg text-white f-12 float-right">Crear tarjeta</a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        @forelse ($usuario->tarjetas as $index => $tarjeta)
                                            <div class="card theme-bg{{($index%2 ==0)?'2':''}} bitcoin-wallet  mb-0">
                                                <div class="card-block">
                                                    <h5 class="text-white mb-2">Tarjeta {{$tarjeta->tipo_tarjeta->tipo_tarjeta}}</h5>
                                                    <h2 class="text-white mb-3 f-w-300">$ {{$tarjeta->transacciones()->where('tipo_transaccion_id',2)->get()->sum('valor')}}</h2>
                                                    <span class="text-white d-block">{{($tarjeta->cupo>0)?'Cupo: $'.$tarjeta->cupo:'Sin cupo establecido'}}</span>
                                                    <h6 class="f-w-600 text-white">
                                                        @if($tarjeta->perdida) PERDIDA @else
                                                        VALIDA HASTA <span class="f-w-300 m-l-10">{{date('m/Y',strtotime($tarjeta->fecha_vencimiento))}}</span>
                                                        @endif
                                                    </h6>
                                                    <a href="" data-toggle="collapse" data-target="#tarjeta-{{$tarjeta->id}}" aria-expanded="false" aria-controls="tarjeta-{{$tarjeta->id}}"><i class="mdi mdi-qrcode-scan f-70 text-white"></i></a>
                                                </div>
                                            </div>
                                            <div class="collapse" id="tarjeta-{{$tarjeta->id}}">
                                                <div class="card-body">
                                                    @if(!$tarjeta->perdida)
                                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($tarjeta->codigo)) !!} ">
                                                    <button type="button" data-toggle="modal" data-target="#tarjetaPerdidaModa" class="btn btn-warning tarjetaPerdidaModaBtn" myid="{{$tarjeta->id}}">Marcar como perdida</button>
                                                    @else
                                                    <h5 class="m-0"><small>Tarjeta perdida el </small>{{\Carbon\Carbon::parse($tarjeta->fecha_perdida)->format('d-m-Y')}}</h5>
                                                    <button type="button" class="btn btn-danger sweet-multiple" myid="{{$tarjeta->id}}">Eliminar</button>
                                                    
                                                    {!! Form::open(['route'=>['institucion.alumno.tarjeta.eliminar',$usuario->id],'method'=>'POST','id'=>'elimina_tarjeta_'.$tarjeta->id]) !!}
                                                        
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::hidden('tarjeta_id', $tarjeta->id) !!}
                                                    {!! Form::close() !!}
                                                    
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="card-block border-bottom">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-auto">
                                                        <i class="feather icon-credit-card f-30"></i>
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="f-w-300 text-c-red" >No hay tarjetas creadas</h3>
                                                        <h6 class="text-muted mt-4 mb-0"> </h6>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            
                            <?php function seleccionado($val,$pes){
                                if($val==$pes) return 'active show';
                                else return '';
                            }?>
                            <!-- [ statistics year chart ] end -->     
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-8 col-md-6">
                                @if($usuario->refrigerio()->count()>0)
                                <div class="card note-bar">
                                    <div class="card-header">
                                        <h5>Refrigerios</h5>
                                        <div class="card-header-right">
                                            <div class="btn-group card-option">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="feather icon-more-horizontal"></i>
                                                </button>
                                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                    <li class="dropdown-item"><a href="{{route('institucion.refrigerio.crear',$usuario->id)}}"><i class="feather icon-plus"></i> Nuevo</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block p-0 row">
                                        @foreach ($usuario->refrigerio as $refrigerio )
                                        <div class="col-md-11">
                                            <a href="#!" class="media friendlist-box">
                                                <div class="mr-3 photo-table">
                                                    <i class="mdi mdi-food f-30 text-c-purple"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6>{{$refrigerio->tipo_refrigerio->tipo}}</h6>
                                                    <span class="f-12 float-right text-muted">${{$refrigerio->costo}}</span>
                                                    <p class="text-muted m-0">
                                                        {{strtoupper(implode(', ',array_values($refrigerio->dias)))}}
                                                        <span class="f-12 float-right text-muted">{{date('d-m-Y',strtotime($refrigerio->fecha_inicio))}}</span>                                            
                                                    </p>
                                                </div>    
                                            </a>
                                        </div>
                                        <div class="col-md-1  media friendlist-box">
                                            <a class="dropdown-toggle addon-btn" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1482px, 99px, 0px);">
                                                <a class="dropdown-item editarRefrigerioModalBtn" href="" myid="{{$refrigerio->id}}" data-toggle="modal" data-target="#editarRefrigerioModal"><i class="icofont icofont-attachment"></i>Editar</a>
                                                <div role="separator" class="dropdown-divider"></div>
                                                <a class="dropdown-item sweet-refrigerio" href="#!" myid="{{$refrigerio->id}}"><i class="icofont icofont-refresh"></i>Eliminar</a>
                                            </div>
                                            {!! Form::open(['route'=>['institucion.refrigerio.eliminar',$refrigerio->id],'method'=>'POST','id'=>'elimina_refrigerio_'.$refrigerio->id]) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::hidden('refrigerio_id', $refrigerio->id) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Ultimas transacciones </h5>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    @forelse ($transacciones as $transaccion )
                                                        
                                                    
                                                    <tr class="unread">
                                                        <td><img class="rounded-circle" style="width:40px;" src="{{Storage::url($transaccion->usuario->foto)}}" alt="activity-user"></td>
                                                        <td>
                                                            <h6 class="mb-1">{{$transaccion->usuario->full_name}} </h6>
                                                            <p class="m-0">{{$transaccion->usuario->telefono}}</p>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-muted">
                                                                <i class="feather f-24  {{($transaccion->tipo_transaccion->operacion=='+')?'text-c-green icon-trending-up' :'text-c-red icon-trending-down' }} f-10 m-r-15"></i>
                                                                $ {{number_format($transaccion->valor,2)}}
                                                            </h6>
                                                            <p class="m-0">{{$transaccion->tipo_transaccion->tipo}} con {{$transaccion->forma_pago->forma_pago}}</p>
                                                        </td>
                                                        <td>
                                                            <p class="m-0">{{date('d-m-Y',strtotime($transaccion->fecha_hora))}}</p>
                                                            <p class="m-0">{{date('H:i',strtotime($transaccion->fecha_hora))}}</p>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <p>No hay usuarios</p>
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{$transacciones->links()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] end-->                                                 
                            <div class="col-xl-8 col-md-8 m-b-30">
                                {{-- <ul class="nav nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('C',$pest)}}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Agenda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('A',$pest)}}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Esta semana</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('T',$pest)}}" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Anteriores</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade {{seleccionado('C',$pest)}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div id="calendar"></div>

                                    </div>
                                    <div class="tab-pane fade {{seleccionado('A',$pest)}}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Tipo visita</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($visitasSemana as $visita)
                                                    <tr>
                                                        <td>
                                                            <h6 class="m-0">{{$visita->cliente->nombre}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{$visita->tipoVisita->tipo}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{Carbon\Carbon::parse($visita->fecha_inicio)->toDayDateTimeString()}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0 @if($visita->estado_visita_id==1)text-c-purple @elseif( $visita->estado_visita_id==6)text-c-red @elseif( $visita->estado_visita_id==5) text-c-green @else text-c-blue  @endif">{{$visita->estado->estado}}</h6>
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="{{route('visita.show',$visita->id)}}" class="label theme-bg2 text-white f-12">Ver</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                        </table>
                                        {{$visitasSemana->appends(['pest'=>'A'])->links()}}
                                    </div>
                                    <div class="tab-pane fade {{seleccionado('T',$pest)}}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>Tipo visita</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($visitasTotal as $visita)
                                                    <tr>
                                                        <td>
                                                            <h6 class="m-0">{{($visita->cliente!=null)?$visita->cliente->nombre:'Cliente no encontrado o eliminado'}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{$visita->tipoVisita->tipo}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{Carbon\Carbon::parse($visita->fecha_inicio)->toDayDateTimeString()}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0 @if($visita->estado_visita_id==1)text-c-purple @elseif( $visita->estado_visita_id==6)text-c-red @elseif( $visita->estado_visita_id==5) text-c-green @else text-c-blue  @endif">{{$visita->estado->estado}}</h6>
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="{{route('visita.show',$visita->id)}}" class="label theme-bg2 text-white f-12">Ver</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                        </table>
                                        {{$visitasTotal->appends(['pest'=>'T'])->links()}}
                                    </div>
                                </div> --}}
                            </div>

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Nueva tarjeta-->
<div class="modal fade" id="tarjetaModa" tabindex="-1" role="dialog" aria-labelledby="tarjetaModaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route'=>['institucion.alumno.tarjeta.store',$usuario->id],'method'=>"POST"]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tarjetas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipo de tarjeta:</label>
                        {!! Form::select('tipo_tarjeta_id', $tipo_tarjetas, 0, ["class"=>"form-control"]) !!}
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Deseas establecer un cupo mensual de gasto, si no dejalo en 0:</label>
                        {!! Form::text('cupo_mensual', 0, ["class"=>"form-control"]) !!}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear tarjeta</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!-- Tarjeta perdida-->
<div class="modal fade" id="tarjetaPerdidaModa" tabindex="-1" role="dialog" aria-labelledby="tarjetaPerdidaModaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(['route'=>['institucion.alumno.tarjeta.perdida',$usuario->id],'method'=>"POST"]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tarjeta perdida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Fecha de perdida:</label>
                        {!! Form::text('fecha_perdida', '', ["class"=>"form-control datepicker"]) !!}
                    </div>
                    <input type="hidden" value="" name="tarjeta_id" id="tarjeta_perdida_id"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<!-- Editar refrigerio-->
<div class="modal fade bd-example-modal-lg" id="editarRefrigerioModal" tabindex="-1" role="dialog" aria-labelledby="editarRefrigerioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="editarRefrigerioModalLabel">Editar refrigerio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="refrigerio_form" method="POST">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="exampleInputPassword1">Tipo de refrigerio</label>
                        {!! Form::select('tipo_refrigerio_id', $tipos_refrigerio,1, ['class'=>'form-control','id'=>'tipo_refrigerio_id']) !!}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Fecha inicio</label>
                        {!! Form::text('fecha_inicio', '', ['class'=>'form-control datepicker','placeholder'=>'Fecha inicio refrigerio','id'=>'fecha_inicio']) !!}
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputPassword1">Fecha fin</label>
                        {!! Form::text('fecha_fin', '', ['class'=>'form-control datepicker','placeholder'=>'Fecha fin refrigerio','id'=>'fecha_fin']) !!}
                        
                    </div>
                    <div class="form-group col-md-12">
                        <h5>Días</h5>                                            
                        <label for="exampleInputPassword1">Lunes</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-lunes" name="dias[]" value="lunes" >
                            <label for="switch-lunes" class="cr"></label>
                        </div>
                        <label for="exampleInputPassword1">Martes</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-martes" name="dias[]" value="martes" >
                            <label for="switch-martes" class="cr"></label>
                        </div>
                        <label for="exampleInputPassword1">Miercoles</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-miercoles" name="dias[]" value="miercoles">
                            <label for="switch-miercoles" class="cr"></label>
                        </div>
                        <label for="exampleInputPassword1">Jueves</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-jueves" name="dias[]" value="jueves">
                            <label for="switch-jueves" class="cr"></label>
                        </div>
                        <label for="exampleInputPassword1">Viernes</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-viernes" name="dias[]" value="viernes">
                            <label for="switch-viernes" class="cr"></label>
                        </div>
                        <label for="exampleInputPassword1">Sabado</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-sabado" name="dias[]" value="sabado" >
                            <label for="switch-sabado" class="cr"></label>
                        </div>
                        <label for="exampleInputPassword1">Domingo</label>
                        <div class="switch switch-primary d-inline m-r-10">
                            <input type="checkbox" id="switch-domingo" name="dias[]" value="domingo" >
                            <label for="switch-domingo" class="cr"></label>
                        </div>
                    </div>
                    
                    {!! Form::hidden('id', 0, ['id'=>'refrigerio_id']) !!}
                    
                    {!! Form::hidden('_method', 'PUT') !!}
                    @csrf
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="refrigerio_update_btn">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/select2/js/select2.full.min.js")}}'></script>
<script src='{{asset("assets/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js")}}'></script>
<script src='{{asset("assets/plugins/sweetalert/js/sweetalert.min.js")}}'></script>
<script>
    $(document).ready(function(){
        $(".select").select2();
        $('.datepicker').datepicker({
            autoclose:true,
            format:'dd-mm-yyyy'
        });
        $('.tarjetaPerdidaModaBtn').on('click', function (e) {
            $('#tarjeta_perdida_id').val($(this).attr('myid'));
        });
        $('.editarRefrigerioModalBtn').on('click', function (e) {
            $('#refrigerio_id').val($(this).attr('myid'));
            $.get("{{url('institucion/refrigerio/')}}/"+$(this).attr('myid'),function(json){
                $('#fecha_inicio').val(moment(json.fecha_inicio).format('DD-MM-YYYY'));
                $('#fecha_fin').val(moment(json.fecha_fin).format('DD-MM-YYYY'));
                $('#tipo_refrigerio_id').val(json.tipo_refrigerio_id);
                json.dias.forEach(function(key){
                    $('#switch-'+key).attr('checked','checked');
                })
            },'json');
        });
        $('#refrigerio_update_btn').on('click',function(){
            $('#refrigerio_form').attr('action','{{url("institucion/refrigerio/update/")}}/'+$('#refrigerio_id').val());
            $('#refrigerio_form').submit();
        })
        $('.sweet-multiple').on('click', function() {
            var tid=$(this).attr('myid');
            swal({
                    title: "Estas seguro?",
                    text: "Estas seguro que desear eliminar la tarjeta",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("La tarjeta ha sido elimina con exito!", {
                            icon: "success",
                        });
                        $('#elimina_tarjeta_'+tid).submit();
                    } else {
                    }
                });
        });
        $('.sweet-refrigerio').on('click', function() {
            var tid=$(this).attr('myid');
            swal({
                    title: "Estas seguro?",
                    text: "Estas seguro que desear eliminar el refrigerio",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("El refrigerio ha sido elimina con exito!", {
                            icon: "success",
                        });
                        $('#elimina_refrigerio_'+tid).submit();
                    } else {
                    }
                });
        });
    });

</script>
@endpush
@push('styles')
<link href='{{asset("assets/plugins/select2/css/select2.min.css")}}' rel='stylesheet' />
{{-- <link href="{{asset('assets/plugins/bootstrap-datetimepicker/css/prettify.css')}}" rel="stylesheet">
<link href="{{asset('assets/plugins/bootstrap-datetimepicker/css/docs.css')}}" rel="stylesheet"> --}}
<link href="{{asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
<script>
        var page = {
            bootstrap: 3
        };

        function swap_bs() {
            page.bootstrap = 3;
        }
    </script>
    <style>
        .datepicker>.datepicker-days {
            display: block;
        }

        ol.linenums {
            margin: 0 0 0 -8px;
        }
    </style>
@endpush
