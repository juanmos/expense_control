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
                                        <h5>Conductores</h5>
                                        <a class="btn btn-primary float-right" href="{{route('conductor.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear conductor</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($conductores->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Foto</th>
                                                        <th>Nombre</th>
                                                        <th>Email</th>
                                                        <th>Telefono</th>
                                                        <th>Vehiculo</th>
                                                        <th>Placa</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($conductores as $conductor)
                                                    <tr class="unread"></tr>
                                                        {{-- <td>{{$conductor->id}}</td> --}}
                                                        <td><img class="rounded-circle" style="width:40px;" src="{{Storage::url($conductor->foto)}}" alt="activity-user"></td>
                                                        <td>{{$conductor->nombre}} {{$conductor->apellido}}
                                                            <i class="fas fa-circle {{($conductor->activo)?'text-c-green':'text-c-red'}} f-10 m-r-15"></i>
                                                        </td>
                                                        <td>{{$conductor->email}}</td>
                                                        <td>{{$conductor->telefono}}</td>
                                                        <td>{{$conductor->conductor->marca}} {{$conductor->conductor->modelo}}</td>
                                                        <td>{{$conductor->conductor->placa}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('conductor.show',$conductor->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('conductor.edit',$conductor->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay conductores registrados</h4>
                                            <a class="btn btn-primary" href="{{route('conductor.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear conductor</span></a>
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
