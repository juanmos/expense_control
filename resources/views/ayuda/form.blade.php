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
                                    @if($ayuda!=null)
                                    <h5 class="m-b-10">Editar ayuda</h5>
                                    @else
                                    <h5 class="m-b-10">Nueva ayuda</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    {{-- <li class="breadcrumb-item"><a href="{{route('naturales.categoria.index',Auth::user()->institucion_id)}}">Ayuda</a></li> --}}
                                    @if($ayuda!=null)
                                    <li class="breadcrumb-item"><a href="javascript:">Editar ayuda</a></li>
                                    @else
                                    <li class="breadcrumb-item"><a href="javascript:">Nueva ayuda</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="{{($ayuda->id!=null)?route('ayuda.update',[$ayuda->id]):route('ayuda.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($ayuda->id!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos de la ayuda</h5>
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
                                                <label for="ruc">Titulo *</label>
                                                <input type="text" value="@if($ayuda!=null){{$ayuda->titulo}}@else{{old('titulo')}}@endif" id="titulo" name="titulo" class="form-control" required="required" aria-describedby="emailHelp" placeholder="Titulo">
                                                <label id="ruc-error" style="display:none"></label>
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Descripción </label>
                                                @trix($ayuda, 'content')      
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="exampleInputEmail1">Video</label>
                                                <input type="text" value="" name="video" class="form-control"  aria-describedby="emailHelp" placeholder="Video">
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
@push('styles')
@trixassets
@endpush
