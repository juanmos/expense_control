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
                            @if(!Auth::user()->hasRole('Vendedor'))
                            <div class="col-xl-3 col-md-3">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">Vendedores</h5>
                                            </div>
                                        </div>
                                        <table class="table table-hover">
                                            <tbody>
                                                @foreach($usuarios as $user)
                                                <tr class="unread" @if($user->id==Auth::user()->id)style="background-color: cornsilk;"@endif>
                                                    <td class="row">
                                                        <div class="col-md-4">
                                                            <img class="rounded-circle" style="width:40px;" src="{{Storage::url($user->foto)}}" alt="activity-user">
                                                        </div>
                                                        <div class="col-md-8">
                                                            {{$user->full_name}} <br>
                                                            <a href="" myid="{{$user->id}}" nombre="{{$user->full_name}}" class="label theme-bg2 text-white f-12 cambiaVendedor">Ver</a>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        
                                                    </td> --}}
                                                </tr>                                              
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->
                            @if(!Auth::user()->hasRole('Vendedor'))
                            <div class="col-xl-9 col-md-9">
                            @else
                            <div class="col-xl-12 col-md-12">
                            @endif
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Visitas - <span id="user_selected">{{Auth::user()->full_name}}</span></h5>
                                        {{-- <a href="{{route('empresa.contacto.create',$empresa->id)}}" class="btn btn-primary float-right"><i class="fas fa-user-plus text-c-white f-10 m-r-15"></i> Nuevo usuario</a> --}}
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <div id="calendar"></div>
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
          url: "{{route('visita.vendedor',$usuario_id)}}", // use the `url` property
        }
      ]
    });

    calendar.render();
  });
  $(document).on('click','.cambiaVendedor',function(e){
      e.preventDefault();
      calendar.getEventSources().forEach(function(es){
          es.remove();
      })
     // calendar.fullCalendar( 'removeEventSources' );
      calendar.addEventSource( "{{url('e/visitas/by/vendedor/')}}/"+$(this).attr('myid') );
      $("tr").css('background-color','transparent')
      $(this).closest('tr').css('background-color','cornsilk')
      $('#user_selected').html($(this).attr('nombre'))
  })
</script>
@endpush
@push('styles')
<link href='{{asset("assets/plugins/fullcalendar/packages/core/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/list/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/bootstrap/main.css")}}' rel='stylesheet' />
@endpush
