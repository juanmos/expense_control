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
                            <!--[ daily sales section ] start-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas diarias</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ 249.95</h3>
                                            </div>

                                            <div class="col-3 text-right">
                                                <p class="m-b-0">67%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ daily sales section ] end-->
                            <!--[ Monthly  sales section ] starts-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card Monthly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas mensuales</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-down text-c-red f-30 m-r-10"></i>$ 2.942.32</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <p class="m-b-0">36%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Monthly  sales section ] end-->
                            <!--[ year  sales section ] starts-->
                            <div class="col-md-12 col-xl-4">
                                <div class="card yearly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas anuales</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ 8.638.32</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <p class="m-b-0">80%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ year  sales section ] end-->
                            <!-- [ statistics year chart ] start -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">{{$cliente->nombre}}</h5>
                                                
                                                <sub class="text-muted f-14"><small>Telf: </small>{{$cliente->telefono}}</sub><br>
                                                <sub class="text-muted f-14"><small>Web: </small>{{$cliente->web}}</sub><br>
                                                <sub class="text-muted f-14"><small>Clasificación: </small>{{$cliente->clasificacion->clasificacion}}</sub>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('cliente.edit',$cliente->id)}}" class="label theme-bg text-white f-12">Editar</a> </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">Datos de facturación</h5>
                                                <sub class="text-muted f-12"><small>RUC: </small>{{$cliente->facturacion->ruc}}</sub><br>
                                                <sub class="text-muted f-12"><small>Telf: </small>{{$cliente->facturacion->telefono_facturacion}}</sub><br>
                                                <sub class="text-muted f-12"><small>Email: </small>{{$cliente->facturacion->email}}</sub><br>
                                                <sub class="text-muted f-12"><small>Dir: </small>{{$cliente->facturacion->direccion}}</sub>
                                            </div>
                                            {{-- <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">34%</label>
                                            </div> --}}
                                        </div>
                                        
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('cliente.edit',$cliente->id)}}" class="label theme-bg text-white f-12">Editar</a> </h6>
                                        <i class="fas fa-file-invoice-dollar text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">Datos de vendedor</h5>
                                                @if($cliente->vendedor!=null)
                                                <sub class="text-muted f-12"><small>Nombre: </small>{{$cliente->vendedor->nombre}} {{$cliente->vendedor->apellido}}</sub><br>
                                                <sub class="text-muted f-12"><small>Telf: </small>{{$cliente->vendedor->telefono}}</sub><br>
                                                <sub class="text-muted f-12"><small>Email: </small>{{$cliente->vendedor->email}}</sub><br>
                                                <sub class="text-muted f-12"><small>Rol: </small>{{$cliente->vendedor->getRoleNames()->implode(',')}}</sub>
                                                @else
                                                <sub class="text-muted f-12">Sin asginar</sub><br>
                                                @endif
                                            </div>
                                            {{-- <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">34%</label>
                                            </div> --}}
                                        </div>
                                        
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('cliente.vendedor',$cliente->id)}}" class="label theme-bg text-white f-12">@if($cliente->vendedor!=null) Editar @else Asignar @endif</a> </h6>
                                        @if($cliente->vendedor!=null)
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('empresa.usuario.show',$cliente->vendedor->id)}}" class="label theme-bg2 text-white f-12">Perfil</a>
                                        @endif
                                        <i class="fas fa-user-tie text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-zap f-30 text-c-green"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300">235</h3>
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
                                                <h3 class="f-w-300">26</h3>
                                                <span class="d-block text-uppercase">TOTAL TERMINADAS</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-8 col-md-6">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Visitas</h5>
                                        {{-- <a href="{{route('empresa.contacto.create',$empresa->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nuevo usuario</a> --}}
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-8">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Contactos</h5>
                                        <a href="{{route('contacto.create',$cliente->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nuevo contacto</a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    @forelse ($cliente->contactos as $contacto )
                                                    <tr class="unread">
                                                        
                                                        <td>
                                                            <h6 class="mb-1"><i class="fas fa-user-tie"></i> {{$contacto->nombre}} {{$contacto->apellido}}</h6>
                                                            <p class="m-0"><i class="fas fa-phone-square-alt"></i> {{$contacto->telefono}} {{($contacto->extension)?' - '.$contacto->extension:''}}</p>
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-1"><i class="fas fa-id-card-alt"></i> {{$contacto->cargo}}</h6>
                                                            <p class="m-0"><i class="fas fa-envelope-open-text"></i> {{$contacto->email}}</p>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('contacto.edit',[$contacto->id] )}}" class="label theme-bg text-white f-12">Editar</a>
                                                            {!! Form::open(['route'=>['contacto.destroy',$contacto->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
                                                            {!! Form::token() !!}
                                                            <button type="submit" class="label theme-danger text-white f-12">Eliminar</button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <p>No hay contactos registrados</p>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Notas importantes</h5>
                                        <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalNota">
                                            <i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nueva nota
                                        </a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($cliente->notas->count() > 0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        
                                                        <th>Nota</th>
                                                        <th>Fecha</th>
                                                        <th>Usuario</th>
                                                        <th class="text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cliente->notas as $nota)
                                                    <tr>
                                                        
                                                        <td>
                                                            <h6 class="m-0">{{$nota->nota}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{date('d-m-Y H:i',strtotime($nota->created_at))}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">
                                                                {{-- <img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user"> --}}
                                                                {{$nota->usuario->full_name}}
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            {!! Form::open(['route'=>['cliente.nota.destroy',$nota->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
                                                            {!! Form::token() !!}
                                                            <button type="submit" class="label theme-danger text-white f-12">Eliminar</button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay notas importantes</h4>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Oficinas</h5>
                                        <a href="{{route('oficina.create',$cliente->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nueva oficina</a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tbody>
                                                    @forelse ($cliente->oficinas as $oficina )
                                                    <tr class="unread">
                                                        <td>
                                                            <h6 class="mb-1"><i class="fas fa-map-marked-alt"></i> {{$oficina->direccion}} </h6>
                                                            <br>
                                                            <h6 class="text-muted"><i class="fas fa-globe-americas"></i> {{$oficina->ciudad->ciudad}}</h6>
                                                        </br>
                                                        <td>
                                                            <a href="{{route('oficina.edit',[$oficina->id] )}}" class="label theme-bg text-white f-12">Editar</a>
                                                            {!! Form::open(['route'=>['oficina.destroy',$oficina->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
                                                            {!! Form::token() !!}
                                                            <button type="submit" class="label theme-danger text-white f-12">Eliminar</button>
                                                            {!! Form::close() !!}
                                                            
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <p>No hay oficinas registradas</p>
                                                    
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] end-->

                            
                            
                            
                            

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.modalNuevaVisitaCliente')
<div class="modal fade bd-example-modal-md" name="modalNota" id="modalNota" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>"cliente.nota.store","method"=>"POST"]) !!}
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Nueva nota</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <div class="form-group-select col-md-12">   
                            <div class="form-group col-md-12 ">                     
                                <label class="col-md-4">Nota:</label>                            
                                {!! Form::text('nota', "", ["class"=>"form-control","placeholder"=>"Nota","required"=>"required"]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button type="submit" class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="{{$cliente->id}}" name="cliente_id"/>
                    </div>    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/fullcalendar/packages/core/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/interaction/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/list/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/core/locales-all.js")}}'></script>
<script>
    var calendar=null;
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
        eventSources: [
            {
            url: "{{route('cliente.visitas',$cliente->id)}}", // use the `url` property
            }
        ],
        dateClick: function(info) {
            var fecha=moment(info.dateStr);
            
            $('#mesModal').val(fecha.format('MM'))
            $('#diaModal').val(fecha.format('DD'));
            $('#anioModal').val(fecha.format('YYYY'));
            $('#horaModal').val(fecha.format('HH'));
            $('#minModal').val(fecha.format('mm'));
            $('#modalAddCita').modal('show');
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