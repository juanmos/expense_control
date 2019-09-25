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
                                        <h5>Hoteles</h5>
                                        <a class="btn btn-primary float-right" href="{{route('hotel.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear hotel</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($hoteles->count()>0)
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Numero</th>
                                                        <th>Nombre</th>
                                                        <th>Direccion</th>
                                                        <th>Telefono</th>
                                                        <th>Email</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($hoteles as $hotel)
                                                    <tr class="unread"></tr>
                                                        <td>{{$hotel->id}}</td>
                                                        <td>{{$hotel->nombre}}</td>
                                                        <td>{{$hotel->direccion}}</td>
                                                        <td>{{$hotel->telefono}}</td>
                                                        <td>{{$hotel->email}}</td>
                                                        <td>
                                                            {{-- <a href="{{ route('afiche.pdf',$afiche->id) }}" class="label theme-bg2 text-white f-12">Descargar</a> --}}
                                                            
                                                            <a href="{{ route('hotel.show',$hotel->id) }}" class="label theme-bg2 text-white f-12">Ver</a>
                                                            <a href="{{ route('hotel.edit',$hotel->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                            
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @else
                                            <h4>No hay hoteles registrados</h4>
                                            <a class="btn btn-primary" href="{{route('hotel.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear hotel</span></a>
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
