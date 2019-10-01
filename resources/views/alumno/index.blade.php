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
                                        <h5>Alumnos {{$institucion->nombre}}</h5>
                                        
                                        <a class="btn btn-primary float-right" href="{{route('institucion.alumno.create',$id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Crear alumno</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('institucion.alumno.cargar',$id)}}"><span class="pcoded-micon"><i class="feather icon-cloud"></i></span><span class="pcoded-mtext"> Cargar alumno</span></a>
                                        <a class="btn btn-secondary float-right" href="{{route('institucion.alumno.exportar',$id)}}"><span class="pcoded-micon"><i class="feather icon-cloud"></i></span><span class="pcoded-mtext"> Exportar alumnos</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($alumnos->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Codigo</th>
                                                        <th>Nombre</th>
                                                        <th>Telefono</th>
                                                        <th>Cedula</th>
                                                        <th>Curso</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($alumnos as $user)
                                                    <tr class="unread"></tr>
                                                        <td>{{$user->id}}</td>
                                                        <td>
                                                            <img class="rounded-circle" style="width:40px;" src="{{Storage::url($user->foto)}}" alt="activity-user">
                                                            {{$user->full_name}}
                                                        </td>
                                                        <td>{{$user->telefono}}</td>
                                                        <td>{{$user->cedula}}</td>
                                                        <td>{{$user->alumno['curso']}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('institucion.alumno.show',[$id,$user->id]) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            {{-- <a href="{{ route('alumno.edit',$alumno->id) }}" class="label theme-bg text-white f-12">Editar</a> --}}
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- {{ $instituciones->links() }} --}}
                                            @else
                                            <h4>No hay alumnos registrados</h4>
                                            <a class="btn btn-primary" href="{{route('alumno.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear alumno</span></a>
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
