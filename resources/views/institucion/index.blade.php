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
                                        <h5>Instituciones / Empresas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('admin.institucion.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear institución</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($instituciones->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Numero</th>
                                                        <th>Nombre</th>
                                                        <th>Estado</th>
                                                        <th>Telefono</th>
                                                        <th>Ciudad</th>
                                                        <th>Tipo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($instituciones as $institucion)
                                                    <tr class="unread"></tr>
                                                        <td>{{$institucion->id}}</td>
                                                        <td>{{$institucion->nombre}}</td>
                                                        <td>{{$institucion->estado->estado}}</td>
                                                        <td>{{$institucion->telefono}}</td>
                                                        <td>{{($institucion->ciudad_id>0)?$institucion->ciudad->ciudad:'Sin ciudad'}}</td>
                                                        <td>{{$institucion->tipoInstitucion->tipo}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('admin.institucion.show',$institucion->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            {{-- <a href="{{ route('institucion.alumnos',$institucion->id) }}" class="label theme-bg2 text-white f-12">Alumnos</a> --}}
                                                            <a href="{{ route('admin.institucion.show',[$institucion->id,'U']) }}" class="label theme-bg2 text-white f-12">Usuarios</a>
                                                            <a href="{{ route('institucion.edit',$institucion->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $instituciones->links() }}
                                            @else
                                            <h4>No hay instituciones registrados</h4>
                                            <a class="btn btn-primary" href="{{route('institucion.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear institución</span></a>
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
