@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    @if($vuelo!=null)
                                    <h5 class="m-b-10">Editar vuelo</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo vuelo</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('aerolinea.index')}}">Vuelos</a></li>
                                    @if($vuelo!=null)
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                    @else
                                    <li class="breadcrumb-item"><a href="javascript:">Nuevo</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{($vuelo!=null)?route('vuelo.update',$vuelo->id):route('vuelo.store',$aerolinea_id)}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($vuelo!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del vuelo</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Vuelo numero</label>
                                                <input type="text" value="@if($vuelo!=null){{$vuelo->vuelo}}@endif" name="vuelo" class="form-control" aria-describedby="emailHelp" placeholder="Numero de vuelo">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Ciudad de origen</label>
                                                <input type="text" value="@if($vuelo!=null){{$vuelo->origen}}@endif" name="origen" class="form-control" id="exampleInputPassword1" placeholder="Ciudad de origen">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Ciudad de destino</label>
                                                <input type="text" value="@if($vuelo!=null){{$vuelo->destino}}@endif" name="destino" class="form-control" id="exampleInputPassword1" placeholder="Ciudad de destino">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Hora de salida</label>
                                                <input type="text" value="@if($vuelo!=null){{$vuelo->hora_salida}}@endif" name="hora_salida" class="form-control" id="exampleInputPassword1" placeholder="Hora de salida">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Hora de llegada</label>
                                                <input type="text" value="@if($vuelo!=null){{$vuelo->hora_llegada}}@endif" name="hora_llegada" class="form-control" id="exampleInputPassword1" placeholder="Hora de llegada">
                                            </div>
                                            <div class="form-inline col-md-12">
                                                <label for="exampleInputPassword1">Lunes</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->lunes)?'checked':''}}@endif name="lunes" class="form-control" value="1">
                                                <label for="exampleInputPassword1">Martes</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->martes)?'checked':''}}@endif name="martes" class="form-control" value="1">
                                                <label for="exampleInputPassword1">Miercoles</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->miercoles)?'checked':''}}@endif name="miercoles" class="form-control" value="1">
                                                <label for="exampleInputPassword1">Jueves</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->jueves)?'checked':''}}@endif name="jueves" class="form-control" value="1">
                                                <label for="exampleInputPassword1">Viernes</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->viernes)?'checked':''}}@endif name="viernes" class="form-control" value="1">
                                                <label for="exampleInputPassword1">Sabado</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->sabado)?'checked':''}}@endif name="sabado" class="form-control" value="1">
                                                <label for="exampleInputPassword1">Domingo</label>
                                                <input type="checkbox" @if($vuelo!=null){{($vuelo->domingo)?'checked':''}}@endif name="domingo" class="form-control" value="1">
                                            </div>
                                            <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

