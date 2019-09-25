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
                                    @if($plantilla!=null)
                                    <h5 class="m-b-10">Editar Plantilla</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo Plantilla</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('plantilla.index')}}">Plantilla</a></li>
                                    @if($plantilla!=null)
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
                <form action="{{($plantilla!=null)?route('plantilla.update',$plantilla->id):route('plantilla.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($plantilla!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la Plantilla</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Nombre de la Plantilla *</label>
                                                <input type="text" value="@if($plantilla!=null){{$plantilla->nombre}}@endif" name="nombre" class="form-control" aria-describedby="emailHelp" placeholder="Plantilla"  required="required">
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Tipo de Plantilla</label>
                                                {!! Form::select('previsita', ['1'=>'Previsita','0'=>'Visita'], ($plantilla!=null)?$plantilla->previsita:0, ["class"=>"form-control"]) !!}
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

