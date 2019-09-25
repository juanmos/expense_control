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
                                        <h5>Aerolineas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('aerolinea.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear aerolinea</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($aerolineas->count()>0)
                                            <div class="col-sm-12">
                                                
                                                <div class="accordion" id="accordionExample">
                                                    @foreach($aerolineas as $aero)
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne">
                                                            <h5 class="mb-0"><a href="#!" data-toggle="collapse" data-target="#collapse{{$aero->id}}" aria-expanded="true" aria-controls="collapseOne">{{$aero->aerolinea}}</a></h5>
                                                            <a href="{{ route('aerolinea.edit',$aero->id) }}" class="label theme-bg text-white f-12 float-right">Editar</a>
                                                            <a class="label btn-primary float-right f-12" href="{{route('vuelo.create',$aero->id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear vuelo</span></a>
                                                        </div>
                                                        <div id="collapse{{$aero->id}}" class=" card-body collapse collapsed" aria-labelledby="heading{{$aero->id}}" data-parent="#accordionExample">
                                                            @if($aero->vuelos->count()>0)
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Vuelo</th>
                                                                        <th>Origen</th>
                                                                        <th>Destino</th>
                                                                        <th>Hora salida</th>
                                                                        <th>Hora llegada</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($aero->vuelos as $vuelo)
                                                                    <tr class="unread"></tr>
                                                                        <td>{{$vuelo->vuelo}}</td>
                                                                        <td>{{$vuelo->origen}}</td>
                                                                        <td>{{$vuelo->destino}}</td>
                                                                        <td>{{$vuelo->hora_salida}}</td>
                                                                        <td>{{$vuelo->hora_llegada}}</td>
                                                                        <td>
                                                                            <a href="{{ route('vuelo.edit',$vuelo->id) }}" class="label theme-bg text-white f-12">Editar</a>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            @else
                                                            <h4>No hay vuelos registrados</h4>
                                                            <a class="btn btn-primary" href="{{route('vuelo.create',$aero->id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear vuelo</span></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    
                                                </div>
                                            </div>
                                            
                                            @else
                                            <h4>No hay aerolineas registrados</h4>
                                            <a class="btn btn-primary" href="{{route('aerolinea.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear conductor</span></a>
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
