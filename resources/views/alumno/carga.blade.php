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
                                    <h5 class="m-b-10">Cargar alumnos</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('alumnos.institucion',$id)}}">Insitucion</a></li>                                    
                                    <li class="breadcrumb-item"><a href="javascript:">Cargar</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                {!! Form::open(['route'=>'institucion.alumno.import','method'=>'POST','enctype'=>"multipart/form-data"]) !!}    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="institucion_id" value="{{ $id }}"/>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Carga de archivo de alumnos</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-12 ">
                                                    <p>Por favor carga el archivo en el formato especificado en el siguiente archivo. El formato debe ser "xlsx"
                                                        <a href="{{asset('archivos/clientes.xlsx')}}" class="btn btn-primary">Descarga el archivo de ejemplo</a>
                                                    </p>
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label for="exampleInputEmail1">Curso</label>
                                                    <input type="text" value="" name="curso" class="form-control" aria-describedby="emailHelp" placeholder="Curso/Paralelo">
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label for="exampleInputEmail1">Año lectivo</label>
                                                    <input type="text" value="" name="ano_lectivo" class="form-control" aria-describedby="emailHelp" placeholder="Año lectivo">
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label for="exampleInputEmail1">Archivo de carga de alumnos</label>
                                                    <input type="file" value="" name="archivo" class="form-control" aria-describedby="emailHelp" placeholder="Archivo">
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
                
                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
</div>
@endsection

