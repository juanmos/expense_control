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
                                                <h5 class="m-0">{{$cliente->cliente->razon_social}}</h5>
                                                
                                                <sub class="text-muted f-14"><small>Telf: </small>{{$cliente->cliente->telefono}}</sub><br>
                                                <sub class="text-muted f-14"><small>RUC: </small>{{$cliente->cliente->ruc}}</sub><br>
                                                <sub class="text-muted f-14"><small>Contacto: </small>{{$cliente->full_name}}</sub>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0"><a href="{{route('naturales.clientes.edit',[$institucion_id,$cliente->id])}}" class="label theme-bg text-white f-12">Editar</a> </h6>
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
                                                <h3 class="f-w-300">235</h3>
                                                <span class="d-block text-uppercase">TOTAL FACTURAS</span>
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
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="ventas-tab" data-toggle="pill" href="#ventas" role="tab" aria-controls="ventas" aria-selected="true">Ventas</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="compras-tab" data-toggle="pill" href="#compras" role="tab" aria-controls="compras" aria-selected="false">Compras</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="ventas" role="tabpanel" aria-labelledby="ventas-tab">
                                                    <table  id="ventasTable" class="table table-hover" style="width:100%">
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
                                                </div>
                                                <div class="tab-pane fade" id="compras" role="tabpanel" aria-labelledby="compras-tab">
                                                    <table  id="comprasTable" class="table table-hover" style="width:100%">
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
    $('#ventasTable').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
        ajax: "{!! route('naturales.facturas.cliente',$cliente->id) !!}",
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'fecha', name: 'fecha' },
            { data: 'cliente.cliente.razon_social', name: 'cliente.cliente.razon_social' },
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
    $('#comprasTable').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
        ajax: "{!! route('naturales.compras.cliente',$cliente->id) !!}",
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'fecha', name: 'fecha' },
            { data: 'cliente.cliente.razon_social', name: 'cliente.cliente.razon_social' },
            
            { data: 'tipoComprobante', name: 'tipoComprobante' },
            { data: 'total', name: 'total' },
            
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/".$institucion_id."/compras")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                {{--  link+='<a href="{{ url("naturales/naturales/".$institucion_id."/clientes")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>';  --}}
                    return link;
                } 
            }
        ]
    });
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