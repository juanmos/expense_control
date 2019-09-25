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
                                    @if($tipoVisita!=null)
                                    <h5 class="m-b-10">Editar tipo de visita</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo tipo de visita</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('tipoVisita.index')}}">Tipo de visita</a></li>
                                    @if($tipoVisita!=null)
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
                <form action="{{($tipoVisita!=null)?route('tipoVisita.update',$tipoVisita->id):route('tipoVisita.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($tipoVisita!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del tipo de la visita</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Tipo de Visita *</label>
                                                <input type="text" value="@if($tipoVisita!=null){{$tipoVisita->tipo}}@endif" name="tipo" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Tipo de visita">
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Plantilla previsita</label>
                                                {!! Form::select('plantilla_pre_id', $plantillas, ($tipoVisita!=null)?$tipoVisita->plantilla_pre_id:1, ["class"=>"form-control"]) !!}
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Plantilla visita</label>
                                                {!! Form::select('plantilla_visita_id', $plantillasVisitas, ($tipoVisita!=null)?$tipoVisita->plantilla_visita_id:1, ["class"=>"form-control"]) !!}
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

