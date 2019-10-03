@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

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
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('institucion.alumno.edit',[$id,$usuario->id])}}" class="label theme-bg text-white f-12">Editar</a> </h6>
                                        <i class="far fa-user text-c-purple f-50"></i>
                                        
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-trending-up f-30 text-c-green"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300 text-c-green" >$ {{$recargas->sum('valor')}}</h3>
                                                <span class="d-block text-uppercase">#{{$recargas->count()}} RECARGAS DEL ULTIMO MES</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-trending-down f-30 text-c-red"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300 text-c-red">$ {{$compras->sum('valor')}}</h3>
                                                <span class="d-block text-uppercase">#{{$compras->count()}} COMPRAS DEL ULTIMO MES</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>QR</h5>
                                        {{-- <a href="{{route('cliente.listado',$usuario->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Asignar cliente</a> --}}
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($usuario->codigo!=null)
                                            {{--  {!!  QrCode::format('svg')->size(300)->generate($usuario->codigo); !!}  --}}
                                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($usuario->codigo)) !!} ">
                                            @else
                                            <a href="{{route('institucion.alumno.codificar',[$id,$usuario->id])}}" class="btn btn-primary">Codificar</a>
                                            @endif
                                        </div>
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
{{-- @include('includes.modalNuevaVisita') --}}
@endsection
@push('scripts')
{{-- <script src='{{asset("assets/plugins/fullcalendar/packages/core/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/interaction/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/list/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/core/locales-all.js")}}'></script>
<script>
    var calendar=null
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid', 'timeGrid', 'list', 'interaction' ],
        locale:'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        defaultView:'{{Auth::user()->empresa->configuracion->defaultView}}',
        hiddenDays: [ 0 ],
        minTime:"{{Auth::user()->empresa->configuracion->min_time}}",
        maxTime:'{{Auth::user()->empresa->configuracion->max_time}}',
        scrollTime:'08:00:00',
        slotDuration:'00:15:00',
        dateClick: function(info) {
            var fecha=moment(info.dateStr);
            $('#modalBuscaCliente').modal('show');
            $('#mesModal').val(fecha.format('MM'))
            $('#diaModal').val(fecha.format('DD'));
            $('#anioModal').val(fecha.format('YYYY'));
            $('#horaModal').val(fecha.format('HH'));
            $('#minModal').val(fecha.format('mm'));
        },
        eventDrop: function(event) {
            if (!confirm("La visita a "+event.event.title + " se reagendara para el: " + moment(event.event.start).format('dddd, DD-MM-YYYY HH:mm')+". Es esto correcto?")) {
                event.revert();
            }else{
                $.ajax({
                    url: '{{url("e/visita")}}/'+event.event.id,
                    type: 'PUT',
                    data:{_token:"{{csrf_token()}}",fecha_inicio:moment(event.event.start).format('YYYY-MM-DD HH:mm:ss'),fecha_fin:moment(event.event.end).format('YYYY-MM-DD HH:mm:ss')},
                    success: function(response) {
                        calendar.refetchEvents();
                    }
                });
            }
        },
        eventResize: function(event) {
            if (!confirm("La visita a "+event.event.title + " terminara ahora: " + moment(event.event.end).format('dddd, DD-MM-YYYY HH:mm')+". Es esto correcto?")) {
                event.revert();
            }else{
                $.ajax({
                    url: '{{url("e/visita")}}/'+event.event.id,
                    type: 'PUT',
                    data:{_token:"{{csrf_token()}}",fecha_fin:moment(event.event.end).format('YYYY-MM-DD HH:mm:ss')},
                    success: function(response) {
                        calendar.refetchEvents();
                    }
                });
            }
        },
        eventSources: [
            {
            url: "{{route('visita.vendedor',$usuario->id)}}", // use the `url` property
            }
        ]
    });

    calendar.render();
  });

</script> --}}
@endpush
@push('styles')
<link href='{{asset("assets/plugins/fullcalendar/packages/core/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/list/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/bootstrap/main.css")}}' rel='stylesheet' />
@endpush
