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
                                        <h5>Clasificaciones</h5>
                                        <a class="btn btn-primary float-right" href="{{route('clasificacion.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear clasificación</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($clasificaciones->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($clasificaciones as $clasificacion)
                                                    <tr class="unread"></tr>
                                                        <td>{{$clasificacion->clasificacion}}</td>
                                                        <td>
                                                            @if($clasificacion->empresa_id!=0)
                                                            <a href="{{ route('clasificacion.edit',$clasificacion->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            {!! Form::open(['route'=>['clasificacion.destroy',$clasificacion->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
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
                                            <h4>No hay clasificaciones registrados</h4>
                                            <a class="btn btn-primary" href="{{route('clasificacion.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear clasificación</span></a>
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
