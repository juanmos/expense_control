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
                                    @if($categoria!=null)
                                    <h5 class="m-b-10">Editar categoria</h5>
                                    @else
                                    <h5 class="m-b-10">Nueva categoria</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('naturales.categoria.index',Auth::user()->institucion_id)}}">Categorias</a></li>
                                    @if($categoria!=null)
                                    <li class="breadcrumb-item"><a href="javascript:">Editar categoria de {{$tipo}}</a></li>
                                    @else
                                    <li class="breadcrumb-item"><a href="javascript:">Nueva categoria de {{$tipo}}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{($categoria!=null)?route('naturales.categoria.update',[$tipo,$categoria->id]):route('naturales.categoria.store',$tipo)}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($categoria!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la categoria de {{$tipo}}</h5>
                                    </div>
                                    <div class="card-body">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="form-group col-md-12 ">
                                                <label for="ruc">Categoria *</label>
                                                <input type="text" value="@if($categoria!=null){{$categoria->categoria}}@else{{old('categoria')}}@endif" id="categoria" name="categoria" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Categoria">
                                                <label id="ruc-error" style="display:none"></label>
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Descripción </label>
                                                <input type="text" value="@if($categoria!=null){{$categoria->descripcion}}@else{{old('descripcion')}}@endif" name="descripcion" class="form-control"  aria-describedby="emailHelp" placeholder="Descripción">
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Icono/Foto</label>
                                                <input type="file" value="" name="foto" class="form-control"  aria-describedby="emailHelp" placeholder="Icono/Foto">
                                            </div>
                                                                                     
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                
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

