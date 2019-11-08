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
                           
                            <!--[ year  sales section ] end-->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-12 col-md-12">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Menus de refrigerios</h5>
                                        <a class="btn btn-primary float-right" href="{{route('institucion.menus.create',Auth::user()->institucion_id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear menu</span></a>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-xl-2 col-md-12">
                                                <div id='external-events' class="external-events">
                                                    <h4>Tipos</h4>
                                                    @foreach ($tipos as $tipo)
                                                    <div class=''>
                                                        
                                                        <button class="btn @if ($loop->first) btn-primary @else btn-light @endif btn-refrigerio" tipo-id="{{$tipo->id}}">{{$tipo->tipo}}</button></div>    
                                                    @endforeach
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-md-12">
                                                <div id='calendar' class='calendar'></div>
                                            </div>
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
<div class="modal fade" id="modalDetalleMenu" tabindex="-1" role="dialog" aria-labelledby="modalDetalleMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle del menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                    <div class="col-3">
                        <img class="img-fluid" id="foto-menu" src="" alt="dashboard-user" id="foto-menu" style="display:none">
                        <i class="f-40 mdi mdi-food" id="no-foto"></i>
                    </div>

                    <div class="col">
                        <h5 class="mb-3" id="titulo-menu">Dashboard UI Kit</h5>
                        <h6 class="m-b-0" id="fecha-menu"></h6>
                        <p class="m-b-0" id="descripcion-menu"></p>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <a href="#"class="btn btn-primary" id="editar-menu">Editar</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
            defaultView:'dayGridMonth',
            {{--  hiddenDays: [ 0 ],  --}}
            scrollTime:'08:00:00',
            slotDuration:'00:15:00',
            eventSources: [
                {
                    url: "{{route('institucion.menus.menus',[Auth::user()->institucion_id,$tipos->first()->id])}}", // use the `url` property
                }
            ],
            eventClick: function(info) {
                console.log(info)
                $('#titulo-menu').html(info.event.extendedProps.titulo);
                $('#descripcion-menu').html(info.event.extendedProps.descripcion);
                $('#fecha-menu').html(moment(info.event.extendedProps.fecha).format('dddd, DD-MM-YYYY'));
                if(info.event.extendedProps.foto==null){
                    $('#foto-menu').hide();
                    $('#no-foto').show();
                }else{
                    console.log('{{url("/")}}/'+info.event.extendedProps.foto.replace('public','storage'))
                    $('#foto-menu').attr('src','{{url("/")}}/'+info.event.extendedProps.foto.replace('public','storage'));
                    $('#no-foto').hide();
                    $('#foto-menu').show();
                }
                $('#editar-menu').attr('href',"{{url('institucion/institucion/'.$institucion_id.'/menus/')}}/"+info.event.id+'/edit');
                $('#modalDetalleMenu').modal('show');
            },
            {{--  eventDrop: function(event) {
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
            },  --}}
            {{--  eventResize: function(event) {
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
            },  --}}
        });

        calendar.render();
        $(document).on('click','.btn-refrigerio',function(e){
            e.preventDefault();
            calendar.getEventSources().forEach(function(es){
                es.remove();
            })
            // calendar.fullCalendar( 'removeEventSources' );
            calendar.addEventSource( "{{url('institucion/institucion/'.$institucion_id.'/menus/menus')}}/"+$(this).attr('tipo-id') );
            $(".btn-refrigerio").removeClass('btn-primary').addClass('btn-light');
            $(this).removeClass('btn-light').addClass('btn-primary');
        })
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