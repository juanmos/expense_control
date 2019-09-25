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
                                        <h5>Usuarios</h5>
                                        
                                        @if(!Request::is('e/usuario/asignar'))  
                                            @if(Auth::user()->hasRole('SuperAdministrador'))
                                            <a class="btn btn-primary float-right" href="{{route('usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
                                            @elseif(Auth::user()->hasRole('Administrador'))
                                            <a class="btn btn-primary float-right" href="{{route('empresa.usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
                                            <a class="btn btn-secondary float-right" href="{{route('empresa.usuario.eliminados')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Usuarios eliminados</span></a>
                                            @elseif(Auth::user()->hasRole('JefeVentas'))
                                            <a class="btn btn-primary float-right" href="{{route('empresa.usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
                                            <a class="btn btn-secondary float-right" href="{{route('empresa.usuario.asignar')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Asignarme vendedores</span></a>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                        @if($usuarios->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Foto</th>
                                                        <th>Nombre</th>
                                                        <th>Email</th>
                                                        <th>Telefono</th>
                                                        <th>Rol</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($usuarios as $user)
                                                    <tr class="unread">
                                                        <td><img class="rounded-circle" style="width:40px;" src="{{Storage::url($user->foto)}}" alt="activity-user"></td>
                                                        <td>{{$user->nombre}} {{$user->apellido}}
                                                            <i class="fas fa-circle {{($user->activo)?'text-c-green':'text-c-red'}} f-10 m-r-15"></i>
                                                        </td>
                                                        <td>{{$user->email}}</td>
                                                        <td>{{$user->telefono}}</td>
                                                        <td>{{$user->getRoleNames()->implode(',')}}</td>
                                                        <td>
                                                        @if(Request::is('e/usuario/asignar'))  
                                                        
                                                            <a href="{{ route('empresa.usuario.asignarme',[$user->id]) }}" class="label theme-bg2 text-white f-12">Asignarme</a>
                                                        @else
                                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                                            <a href="{{ route('usuario.show',$user->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('usuario.edit',$user->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            @else
                                                                @if($user->trashed())
                                                                    <a href="{{ route('empresa.usuario.restaurar',$user->id) }}" class="label theme-bg2 text-white f-12">Restaurar</a>
                                                                @else
                                                                    <a href="{{ route('empresa.usuario.show',$user->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                                    <a href="{{ route('empresa.usuario.edit',$user->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                                    {!! Form::open(['route'=>['empresa.usuario.destroy',$user->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                                    <input type="hidden" value="DELETE" name="_method"/>
                                                                    {!! Form::token() !!}
                                                                    <button type="submit" class="label theme-danger text-white f-12">Eliminar</button>
                                                                    {!! Form::close() !!}
                                                                @endif
                                                            @endif
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{$usuarios->links()}}
                                        @else
                                            <h4>No hay usuarios registrados</h4>
                                            @if(Auth::user()->hasRole('SuperAdmin'))
                                            <a class="btn btn-primary float-right" href="{{route('usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
                                            @else
                                            <a class="btn btn-primary float-right" href="{{route('empresa.usuario.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear usuario</span></a>
                                            @endif
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
