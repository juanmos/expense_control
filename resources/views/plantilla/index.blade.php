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
                                        <h5>Plantillas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('plantilla.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear plantilla</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($plantillas->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Tipo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($plantillas as $plantilla)
                                                    <tr class="unread"></tr>
                                                        <td>{{$plantilla->nombre}}</td>
                                                        <td>{{($plantilla->previsita==1)?'Previsita':'Visita'}}</td>
                                                        <td>
                                                            <a href="{{ route('plantilla.show',$plantilla->id) }}" class="label theme-bg text-white f-12">Ver</a>
                                                            @if($plantilla->empresa_id!=0 || Auth::user()->hasRole('SuperAdministrador'))
                                                            <a href="{{ route('plantilla.edit',$plantilla->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            {!! Form::open(['route'=>['plantilla.destroy',$plantilla->id],'method'=>'POST','style'=>'display:inline-block']) !!}
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
                                            <h4>No hay plantillas registrados</h4>
                                            <a class="btn btn-primary" href="{{route('plantilla.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear plantilla</span></a>
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
