@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                @include('includes.mensaje')
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!--[ daily sales section ] start-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Facturas utlimos 7 días</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ {{$dia}}</h3>
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
                                        <h6 class="mb-4">Facturas mensuales</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-down text-c-red f-30 m-r-10"></i>$ {{$mes}}</h3>
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
                                        <h6 class="mb-4">Facturas anuales</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ {{$ano}}</h3>
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
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-12 col-md-12">
                                <div class="card Recent-Users">
                                    <div class="card-header row">
                                        <div class="col-md-8">
                                            <h5 class="">Facturas de venta</h5>
                                        </div>                                        
                                        <div class="col-md-3">
                                            <div class="input-daterange input-group" id="datepicker_range">
                                                <input type="text" class="form-control text-left" placeholder="Fecha inicio" value="{{$start}}" name="start" id="start">
                                                <input type="text" class="form-control text-right" placeholder="Fecha fin" name="end" id="end"  value="{{$end}}">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" id="filter" class="btn btn-icon btn-rounded btn-primary"><i class="feather icon-filter"></i></button>
                                        </div>
                                        
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pills-electronicas-tab" data-toggle="pill" href="#pills-electronicas" role="tab" aria-controls="pills-electronicas" aria-selected="true">Electrónicas</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-fisicas-tab" data-toggle="pill" href="#pills-fisicas" role="tab" aria-controls="pills-fisicas" aria-selected="false">Físicas</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-electronicas" role="tabpanel" aria-labelledby="pills-electronicas-tab">
                                                    @if($institucion->configuracion->configuraciones!=null && array_key_exists('firma',$institucion->configuracion->configuraciones))
                                                    <a href="{{route('naturales.facturas.create',$institucion_id)}}" class="btn btn-primary float-right"><i class="mdi mdi-credit-card text-c-white f-10 m-r-15"></i> Nueva factura</a>
                                                    <table  id="tableData" class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Razón social</th>                                                        
                                                                <th>Estado</th>
                                                                <th>Numero</th>
                                                                <th>Total</th>                                                        
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="entrydata">
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <div class="">
                                                        <div class="col-md-10">
                                                            <h5 class="">No tienes tu firma electronica cargada</h5>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <a href="{{route('naturales.configuracion.edit')}}" id="filter" class="btn btn-sm btn-primary">Cargar firma</a>
                                                        </div>
                                                        <p>Sigue los pasos para obtener tu firma electrónica</p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="tab-pane fade" id="pills-fisicas" role="tabpanel" aria-labelledby="pills-fisicas-tab">
                                                    <a href="{{route('naturales.documentos.create',[$institucion_id,'factura'])}}" class="btn btn-primary float-right"><i class="fas fa-plus text-c-white f-10 m-r-15"></i> Ingresar factura</a>
                                                    <table  id="tableFisicas" class="table table-hover"  style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Razón social</th>                                                        
                                                                <th>Tipo</th>
                                                                <th>Total</th>                                                        
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="entrydata">
                                                        </tbody>
                                                    </table>
                                                </div>
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

@endsection
@push('scripts')
<!-- Datepicker Js -->
<script src='{{asset("assets/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js")}}'>
</script>
<script src='{{asset("assets/plugins/data-tables/js/datatables.min.js")}}'></script>
<script>
$(function() {
    $(document).on('click','#filter',function(){
        table.destroy();
        tableFisicas.destroy();
 
        table = $('#tableData').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "order": [[ 1, "desc" ]],
            ajax: "{!! route('naturales.facturas.data',$institucion_id) !!}?start_date="+$('#start').val()+'&end_date='+$('#end').val(),
            columns: [
                // { data: 'id', name: 'id' },
                
                { data: 'cliente.cliente.nombre_comercial', name: 'cliente.cliente.nombre_comercial' },
                { data: 'fecha', name: 'fecha' },
                { data: 'estado.estado', name: 'estado.estado' },
                { data: 'secuencia', name: 'secuencia' },
                { data: 'total', name: 'total' },
                
                { "data": "id", render: function (dataField) { 
                    var link='<a href="{{ url("naturales/naturales/".$institucion_id."/facturas")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                    link+='<a href="{{ url("naturales/naturales/".$institucion_id."/facturas")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>';
                        return link;
                    } 
                }
            ]
        });
        tableFisicas = $('#tableFisicas').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 50,
            "order": [[ 0, "desc" ]],
            ajax: "{!! route('naturales.documentos.index','factura') !!}?start_date="+$('#start').val()+'&end_date='+$('#end').val(),
            columns: [
                // { data: 'id', name: 'id' },
                { data: 'fecha', name: 'fecha' },
                { data: 'cliente.nombre_comercial', name: 'cliente.nombre_comercial' },
                
                { data: 'documento', name: 'documento' },
                { data: 'total', name:'total'},
                
                { "data": "id", render: function (dataField) { 
                        return '<a href="{{ url("naturales/naturales/".$institucion_id."/documento")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>'; 
                    } 
                }
            ]
        });
    })
    var table = $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
        ajax: "{!! route('naturales.facturas.data',$institucion_id) !!}?start_date="+$('#start').val()+'&end_date='+$('#end').val(),
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'fecha', name: 'fecha' },
            { data: 'cliente.cliente.nombre_comercial', name: 'cliente.cliente.nombre_comercial' },
            { data: 'estado.estado', name: 'estado.estado' },
            { data: 'secuencia', name: 'secuencia' },
            { data: 'total', name: 'total' },
            
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/".$institucion_id."/facturas")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                 link+='<a href="{{ url("naturales/naturales/".$institucion_id."/facturas")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>'; 
                    return link;
                } 
            }
        ]
    });
    var tableFisicas = $('#tableFisicas').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
        ajax: "{!! route('naturales.documentos.index','factura') !!}?start_date="+$('#start').val()+'&end_date='+$('#end').val(),
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'fecha', name: 'fecha' },
            { data: 'cliente.nombre_comercial', name: 'cliente.nombre_comercial' },
            
            { data: 'documento', name: 'documento' },
            { data: 'total', name:'total'},
            
            { "data": "id", render: function (dataField) { 
                    return '<a href="{{ url("naturales/naturales/".$institucion_id."/documento")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>'; 
                } 
            }
        ]
    });
    $('#datepicker_range').datepicker({autoclose:true,
            format:'dd-mm-yyyy'});
    });
</script>
@endpush
@push('styles')
<link rel="stylesheet" href='{{asset("assets/plugins/data-tables/css/datatables.min.css")}}'>
<!-- Datepicker css -->
<link href='{{asset("assets/plugins/bootstrap-datetimepicker/css/prettify.css")}}' rel="stylesheet">
<link href='{{asset("assets/plugins/bootstrap-datetimepicker/css/docs.css")}}' rel="stylesheet">
<link href='{{asset("assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css")}}' rel="stylesheet">
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