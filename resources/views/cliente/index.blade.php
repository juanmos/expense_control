@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('includes.mensaje')
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
                                        <h5>Clientes</h5>
                                        <a class="btn btn-primary float-right" href="{{route('naturales.clientes.create',$institucion_id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear cliente</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('naturales.clientes.upload',$institucion_id)}}"><span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span><span class="pcoded-mtext">Cargar clientes</span></a>
                                        
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="">
                                            {!! Form::open() !!}
                                                <div class="row overflow-y-auto">                            
                                                    <div class="col-md-3">
                                                        <label>Buscar cliente:</label>
                                                    </div>
                                                    <div class="col-md-7">                                
                                                        <input type="text" name="buscar" required id="buscar" class="form-control borderColorElement" value="" placeholder="Escriba el nombre de la empresa o el RUC">
                                                    </div>
                                                </div>
                                            {!! Form::close()!!}
                                        </div>
                                        <div class="table-responsive">
                                        @if($clientes->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>RUC/Cedula</th>
                                                        <th>Telefono</th>
                                                        <th>Nombre completo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="entrydata">
                                                    @foreach($clientes as $cliente)
                                                    <tr class="unread"></tr>
                                                        <td>{{$cliente->cliente->razon_social}}</td>
                                                        <td>{{$cliente->cliente->ruc}}</td>
                                                        <td>{{$cliente->cliente->telefono}}</td>
                                                        <td>{{$cliente->nombre.' '.$cliente->apellido}}</td>
                                                        <td>
                                                            
                                                            <a href="{{ route('naturales.clientes.show',[$institucion_id,$cliente->id]) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('naturales.clientes.edit',[$institucion_id,$cliente->id]) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $clientes->links() }}
                                        @else
                                            <h4>No hay clientes registrados</h4>
                                            <a class="btn btn-primary" href="{{route('naturales.clientes.create',$institucion_id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear cliente</span></a>
                                        @endif
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
<script>
    $(document).ready(function(e){
        $('#buscar').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
        $(document).on('keyup', '#buscar', function(event){            
            if($(this).val().length == 0){
                $('#buscar').blur();
                lista();
                $('#buscar').focus();
            }else if($(this).val().length >= 2){
                if((event.keyCode == 8) || (event.keyCode == 32) || (event.keyCode == 35) || (event.keyCode == 36) || (event.keyCode == 37) || (event.keyCode == 39)){
                    $('#entrydata').empty();
                }else{
                    $('#buscar').blur();
                    lista();
                    $('#buscar').focus();
                }
            }else{
                $('#entrydata').empty();

            }
        });
        function lista (){
            var data = {buscar:$('#buscar').val(),vendedor_id:{{Auth::user()->id}}, _token:"{{csrf_token()}}" };
            $.post("{{route('naturales.clientes.data',$institucion_id)}}",data, function(json){
                $('#entrydata').empty();
                $('.pagination').hide();
                json.clientes.data.forEach(function(cliente){
                    var web=(cliente.web!=null)?cliente.web:'';
                    var telefono=(cliente.telefono!=null)?cliente.telefono:'';
                    var direccion=(cliente.facturacion!=null)?cliente.facturacion.direccion:'';
                    var vendedor=(cliente.vendedor!=null)?cliente.vendedor.nombre+' '+cliente.vendedor.apellido:'Sin asignar';
                    $('#entrydata').append('<tr><td>'+cliente.nombre+'</td><td>'+direccion+'</td><td>'+telefono+'</td><td>'+vendedor+'</td><td><a href="{{ url("/")}}/cliente/'+cliente.id+'" class="label theme-bg2 text-white f-12">Ver</a><a href="{{ url("/")}}/cliente/'+cliente.id+'/edit" class="label theme-bg text-white f-12">Editar</a></td></tr>');    
                })
            } ,'json');            
        }
    })
</script>
@endpush