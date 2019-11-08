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
                                                    <div class='fc-event'>{{$tipo->tipo}}</div>    
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
                <table class="table table-striped">
                    <tr>
                        <th>Mes de pago</th>
                        <th>Valor</th>
                        <th>Forma de pago</th>
                        <th>No Factura</th>
                    </tr>
                    <tbody id="historialPagosTable"></tbody>
                    
                </table>         
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/plugins/fullcalendar/js/fullcalendar.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            
            editable: true,
            droppable: true,
            eventSources: [
                {
                    url: "{{route('institucion.menus.menus',[Auth::user()->institucion_id,$tipos->first()->id])}}", // use the `url` property
                }
            ],
            dateClick: function(info) {
                //var fecha=moment(info.dateStr);
                $('#modalDetalleMenu').modal('show');
                // $('#mesModal').val(fecha.format('MM'))
                // $('#diaModal').val(fecha.format('DD'));
                // $('#anioModal').val(fecha.format('YYYY'));
                // $('#horaModal').val(fecha.format('HH'));
                // $('#minModal').val(fecha.format('mm'));
            },
        });
    })
</script>
@endpush
@push('styles')
<link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/css/fullcalendar.min.css')}}">
@endpush