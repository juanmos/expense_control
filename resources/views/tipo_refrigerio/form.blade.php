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
                                    @if($tipo!=null)
                                    <h5 class="m-b-10">Editar tipo de refrigerio</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo tipo de refrigerio</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('institucion.refrigerios.tipos.index')}}">Tipo de refrigerio</a></li>
                                    @if($tipo!=null)
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
                <form action="{{($tipo!=null)?route('institucion.refrigerios.tipos.update',$tipo->id):route('institucion.refrigerios.tipos.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($tipo!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del tipo de refrigerio</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Tipo de refrigerio *</label>
                                                <input type="text" value="@if($tipo!=null){{$tipo->tipo}}@endif" name="tipo" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Tipo de refrigerio">
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Descripción</label>
                                                {!! Form::text('descripcion', ($tipo!=null)?$tipo->descripcion:'', ["class"=>"form-control","placeholder"=>'Descripción']) !!}
                                                
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Costo $</label>
                                                {!! Form::number('costo', ($tipo!=null)?$tipo->costo:'', ["class"=>"form-control","placeholder"=>'Costo $']) !!}
                                                
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

