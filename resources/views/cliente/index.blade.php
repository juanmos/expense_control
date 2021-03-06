@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('includes.mensaje')
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/home')}}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('naturales.clientes.index',$institucion_id)}}">Clientes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Listado</li>
                    </ol>                 
                </nav>
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
                                        <h5>Clientes</h5>
                                        <a class="btn btn-primary float-right" href="{{route('naturales.clientes.create',$institucion_id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear cliente</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('naturales.clientes.upload',$institucion_id)}}"><span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span><span class="pcoded-mtext">Cargar clientes</span></a>
                                        
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table  id="tableData" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre comercial</th>
                                                        <th>RUC/Cedula</th>
                                                        <th>Teléfono</th>
                                                        <th>Dirección</th>
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
<script src='{{asset("assets/plugins/data-tables/js/datatables.min.js")}}'></script>
<script>
$(function() {
    $('#tableData').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        ajax: "{!! route('naturales.clientes.data',$institucion_id) !!}",
        columns: [
            // { data: 'id', name: 'id' },
            
            { data: 'cliente.nombre_comercial', name: 'cliente.nombre_comercial' },
            { data: 'cliente.ruc', name: 'cliente.ruc' },
            { data: 'cliente.telefono', name: 'cliente.telefono' },
            { data: 'cliente.direccion', name: 'cliente.direccion' },
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/".$institucion_id."/clientes")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                link+='<a href="{{ url("naturales/naturales/".$institucion_id."/clientes")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>';
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
@endpush