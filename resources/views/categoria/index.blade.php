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
                        <li class="breadcrumb-item"><a href="{{route('naturales.categoria.index',$tipo)}}">Categoria</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Productos y servicios</li>
                    </ol>                 
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <?php function seleccionado($val,$pes){
                                if($val==$pes) return 'active show';
                                else return '';
                            }?>
                            <!--[ year  sales section ] end-->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-12 col-md-12">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('producto',$tipo)}}" id="pills-productos-tab" data-toggle="pill" href="#pills-productos" role="tab" aria-controls="pills-productos" aria-selected="true">Productos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('servicio',$tipo)}}" id="pills-servicios-tab" data-toggle="pill" href="#pills-servicios" role="tab" aria-controls="pills-servicios" aria-selected="false">Servicios</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade {{seleccionado('producto',$tipo)}}" id="pills-productos" role="tabpanel" aria-labelledby="pills-productos-tab">
                                        <a class="btn btn-primary float-right" href="{{route('naturales.categoria.create','producto')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear producto</span></a>
                                        <table  id="tableProducto" class="table table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th>Descripcion</th>
                                                    <th>Icono/Foto</th>
                                                    
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade {{seleccionado('servicio',$tipo)}}" id="pills-servicios" role="tabpanel" aria-labelledby="pills-servicios-tab">
                                        <a class="btn btn-primary float-right" href="{{route('naturales.categoria.create','servicio')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear servicio</span></a>
                                        <table  id="tableServicios" class="table table-hover" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Categoria</th>
                                                    <th>Descripcion</th>
                                                    <th>Icono/Foto</th>
                                                    
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
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
{!! Form::open(['method'=>'POST','id'=>'elimina_categoria']) !!}
    {!! Form::hidden('_method', 'DELETE') !!}
{!! Form::close() !!}
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/sweetalert/js/sweetalert.min.js")}}'></script>
<script src='{{asset("assets/plugins/data-tables/js/datatables.min.js")}}'></script>
<script>
$(function() {
    $('#tableServicios').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        ajax: "{!! route('naturales.categoria.data','servicio') !!}",
        columns: [
            // { data: 'id', name: 'id' },
            
            { data: 'categoria', name: 'categoria' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'icono', name: 'icono' },
            
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/servicio/categoria")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                link+='<a href="{{ url("naturales/naturales/servicio/categoria")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>';
                link+='<a href="#" myid="'+dataField+'" tipo="servicio" class="label theme-bg eliminar-categoria text-white f-12">Eliminar</a>';
                    return link;
                } 
            }
        ]
    });
    $('#tableProducto').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        ajax: "{!! route('naturales.categoria.data','producto') !!}",
        columns: [
            // { data: 'id', name: 'id' },
            
            { data: 'categoria', name: 'categoria' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'icono', name: 'icono' },
            
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/producto/categoria")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                link+='<a href="{{ url("naturales/naturales/producto/categoria")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>';
                link+='<a href="#" myid="'+dataField+'" tipo="producto" class="label theme-bg eliminar-categoria text-white f-12">Eliminar</a>';
                    return link;
                } 
            }
        ]
    });
});
$(document).ready(function(){
    $(document).on('click','.eliminar-categoria', function() {
        var tid=$(this).attr('myid');
        var tipo=$(this).attr('tipo');
        swal({
                title: "Estas seguro?",
                text: "Estas seguro que deseas eliminar la categoria y todos sus productos!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Tu categoria sera eliminada!", {
                        icon: "success",
                    });
                    $('#elimina_categoria').attr('action','{{url("naturales/naturales/")}}/'+tipo+'/categoria/'+tid);
                    $('#elimina_categoria').submit();
                } else {
                    swal("Your imaginary file is safe!", {
                        icon: "error",
                    });
                }
            });
    });
})    
</script>
@endpush
@push('styles')
<link rel="stylesheet" href='{{asset("assets/plugins/data-tables/css/datatables.min.css")}}'>
@endpush