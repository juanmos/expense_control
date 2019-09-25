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
                                                <h5 class="m-0">{{$usuario->full_name}}</h5>
                                                
                                                <sub class="text-muted f-14"><small>Telf: </small>{{$usuario->telefono}}</sub><br>
                                                <sub class="text-muted f-14"><small>Web: </small>{{$usuario->web}}</sub><br>
                                                <sub class="text-muted f-14"><small>Cedula: </small>{{$usuario->cedula}}</sub>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('empresa.usuario.edit',$usuario->id)}}" class="label theme-bg text-white f-12">Editar</a> </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-zap f-30 text-c-green"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300">{{$visitasTotal->total()}}</h3>
                                                <span class="d-block text-uppercase">TOTAL VISITAS</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-map-pin f-30 text-c-blue"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300">{{$visitasTerminadas}}</h3>
                                                <span class="d-block text-uppercase">TOTAL TERMINADAS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Clientes</h5>
                                        <a href="{{route('cliente.listado',$usuario->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Asignar cliente</a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    @forelse ($usuario->clientes as $cliente )
                                                    <tr class="unread">
                                                        
                                                        <td>
                                                            <h6 class="mb-1"><i class="fas fa-user-tie"></i> {{$cliente->nombre}}</h6>
                                                            <p class="m-0"><i class="fas fa-phone-square-alt"></i> {{$cliente->telefono}}</p>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('cliente.show',[$cliente->id] )}}" class="label theme-bg text-white f-12">Ver</a>
                                                            <a href="{{route('cliente.show',[$cliente->id] )}}" class="label theme-bg2 text-white f-12">Visita</a>
                                                            <a href="{{route('cliente.desasignar',[$usuario->id,$cliente->id] )}}" class="label theme-danger text-white f-12">Quitar</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <p>No hay cliente asignados</p>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php function seleccionado($val,$pes){
                                if($val==$pes) return 'active show';
                                else return '';
                            }?>
                            <!-- [ statistics year chart ] end -->                                                      
                            <div class="col-xl-8 col-md-8 m-b-30">
                                <ul class="nav nav-pills" id="myTab" role="tablist">
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
                                </div>
                            </div>

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.modalNuevaVisita')
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/fullcalendar/packages/core/main.js")}}'></script>
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

</script>
@endpush
@push('styles')
<link href='{{asset("assets/plugins/fullcalendar/packages/core/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/list/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/bootstrap/main.css")}}' rel='stylesheet' />
@endpush