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
                                    @if($hotel!=null)
                                    <h5 class="m-b-10">Editar hotel</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo hotel</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('hotel.index')}}">Hoteles</a></li>
                                    @if($hotel!=null)
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
                <form action="{{($hotel!=null)?route('hotel.update',$hotel->id):route('hotel.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($hotel!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del hotel</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Hotel</label>
                                                <input type="text" value="@if($hotel!=null){{$hotel->nombre}}@endif" name="nombre" class="form-control" aria-describedby="emailHelp" placeholder="Hotel">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Dirección</label>
                                                <input type="text" value="@if($hotel!=null){{$hotel->direccion}}@endif" name="direccion" class="form-control" id="exampleInputPassword1" placeholder="Dirección">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="email" value="@if($hotel!=null){{$hotel->email}}@endif" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($hotel!=null){{$hotel->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Web</label>
                                                <input type="text" value="@if($hotel!=null){{$hotel->web}}@endif" name="web" class="form-control" id="exampleInputPassword1" placeholder="Web">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Facebook</label>
                                                <input type="text" value="@if($hotel!=null){{$hotel->facebook}}@endif" name="facebook" class="form-control" id="exampleInputPassword1" placeholder="Facebook">
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

