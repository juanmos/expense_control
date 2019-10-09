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
                                        <h5>Tipos de refrigerios</h5>
                                        <a class="btn btn-primary float-right" href="{{route('institucion.refrigerios.tipos.crear')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear tipo de refrigerio</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($tipos->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo</th>
                                                        <th>Descripción</th>
                                                        <th>Costo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tipos as $tipo)
                                                    <tr class="unread"></tr>
                                                        <td>{{$tipo->tipo}}</td>
                                                        <td>{{$tipo->descripcion}}</td>
                                                        <td><h5>$ {{$tipo->costo}}</h5></td>
                                                        <td>

                                                            <a href="{{ route('institucion.refrigerios.tipos.editar',$tipo->id) }}" class="btn btn-primary btn-rounded btn-sm f-12">Editar</a>
                                                            {!! Form::open(['route'=>['institucion.refrigerios.tipos.destroy',$tipo->id],'method'=>'POST','style'=>'display:inline-block']) !!}
                                                            <input type="hidden" value="DELETE" name="_method"/>
                                                            {!! Form::token() !!}
                                                            <button type="submit" class="btn btn-danger btn-rounded btn-sm f-12">Eliminar</button>
                                                            {!! Form::close() !!}
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay tipo de refrigerios</h4>
                                            <a class="btn btn-primary" href="{{route('institucion.refrigerios.tipos.crear')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear tipo de refrigerio</span></a>
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
