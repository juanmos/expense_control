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
                        <li class="breadcrumb-item active" aria-current="page">Alumno</li>
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
                                        <h5>Alumnos {{$institucion->nombre}}</h5>
                                        
                                        <a class="btn btn-primary float-right" href="{{route('institucion.alumno.create',$id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Crear alumno</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('institucion.alumno.cargar',$id)}}"><span class="pcoded-micon"><i class="feather icon-cloud"></i></span><span class="pcoded-mtext"> Cargar alumno</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('institucion.alumno.exportar',$id)}}"><span class="pcoded-micon"><i class="feather icon-cloud"></i></span><span class="pcoded-mtext"> Exportar alumnos</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Codigo</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <th>Telefono</th>
                                                        <th>Cedula</th>
                                                        <th>Curso</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
    $('.table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!! route('institucion.alumnos.data',$id) !!}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nombre', name: 'nombre' },
            { data: 'apellido', name: 'apellido' },
            { data: 'telefono', name: 'telefono' },
            { data: 'cedula', name: 'cedula' },
            { data: 'alumno.curso', name: 'updated_at' },
            { "data": "id", render: function (dataField) { 
                return '<a href="{{ url("institucion/".$id."/alumno/")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a> <a href="{{ url("institucion/".$id."/alumno/edit/")}}/'+dataField+'"" class="label theme-bg text-white f-12">Editar</a>';
                    
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