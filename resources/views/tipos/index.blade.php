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
                                        <h5>Tipos de visitas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('tipoVisita.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear tipo de visita</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($tipos->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Plantilla previsita</th>
                                                        <th>Plantilla visita</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tipos as $tipo)
                                                    <tr class="unread"></tr>
                                                        <td>{{$tipo->tipo}}</td>
                                                        <td>{{$tipo->plantillaPre->nombre}}</td>
                                                        <td>{{$tipo->plantillaVisita->nombre}}</td>
                                                        <td>
                                                            @if($tipo->empresa_id!=0)
                                                            <a href="{{ route('tipoVisita.edit',$tipo->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            {!! Form::open(['route'=>['tipoVisita.destroy',$tipo->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
                                                            {!! Form::token() !!}
                                                            <button type="submit" class="label theme-danger text-white f-12">Eliminar</button>
                                                            {!! Form::close() !!}
                                                            @else
                                                            <span class="label theme-danger text-white f-12">No se puede editar/borrar</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay tipo de visitas registrados</h4>
                                            <a class="btn btn-primary" href="{{route('tipoVisita.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear tipo de visita</span></a>
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
