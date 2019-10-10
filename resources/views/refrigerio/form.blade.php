@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        @include('includes.mensaje')
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    @if($refrigerio!=null)
                                    <h5 class="m-b-10">Editar refrigerio</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo refrigerio</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('institucion.refrigerio.index')}}">Refrigerios</a></li>
                                    @if($refrigerio!=null)
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
                <form action="{{($refrigerio!=null)?route('institucion.refrigerio.update',[$refrigerio->id]):route('institucion.refrigerio.store')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($refrigerio!=null)?'PUT':'POST'}}"/>
                    
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <img class="rounded-circle float-right" style="width:60px;" src="{{Storage::url($usuario->foto)}}" alt="activity-user">
                                                <h5 class="m-0">{{$usuario->full_name}}</h5>
                                                <div class="row">
                                                    <div class="text-muted f-14 col-md-6"><small>Email: </small>{{$usuario->email}}</div>
                                                    <div class="text-muted f-14 col-md-6"><small>Telf: </small>{{$usuario->telefono}}</div>
                                                    <div class="text-muted f-14 col-md-6"><small>Celular: </small>{{$usuario->celular}}</div>
                                                    <div class="text-muted f-14 col-md-6"><small>Cedula: </small>{{$usuario->cedula}}</div>
                                                    <div class="text-muted f-14 col-md-6"><small>Curso: </small>{{$usuario->alumno->curso}}</div>
                                                    <div class="text-muted f-14 col-md-6"><small>Ano lectivo: </small>{{$usuario->alumno->ano_lectivo}}</div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            <a href="{{route('institucion.alumno.show',[Auth::user()->id,$usuario->id])}}" class="label theme-bg text-white f-12">Ver</a> 
                                            <a href="{{route('institucion.alumno.edit',[Auth::user()->id,$usuario->id])}}" class="label theme-bg2 text-white f-12">Editar</a> 
                                        </h6>
                                        <i class="far fa-user text-c-purple f-50"></i>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del refrigerio</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputPassword1">Tipo de refrigerio</label>
                                                {!! Form::select('tipo_refrigerio_id', $tipos,($refrigerio!=null)?$refrigerio->tipo_refrigerio_id:1, ['class'=>'form-control']) !!}
                                                
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Fecha inicio</label>
                                                {!! Form::text('fecha_inicio', ($refrigerio!=null)?$refrigerio->fecha_inicio:'', ['class'=>'form-control datepicker','placeholder'=>'Fecha inicio refrigerio']) !!}
                                                
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Fecha fin</label>
                                                {!! Form::text('fecha_fin', ($refrigerio!=null)?$refrigerio->fecha_fin:'', ['class'=>'form-control datepicker','placeholder'=>'Fecha fin refrigerio']) !!}
                                                
                                            </div>
                                            <div class="form-group col-md-12">
                                                <h5>Días</h5>                                            
                                                <label for="exampleInputPassword1">Lunes</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="lunes" checked>
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                                <label for="exampleInputPassword1">Martes</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="martes" checked>
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                                <label for="exampleInputPassword1">Miercoles</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="miercoles" checked>
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                                <label for="exampleInputPassword1">Jueves</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="jueves" checked>
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                                <label for="exampleInputPassword1">Viernes</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="viernes" checked>
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                                <label for="exampleInputPassword1">Sabado</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="sabado" >
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                                <label for="exampleInputPassword1">Domingo</label>
                                                <div class="switch switch-primary d-inline m-r-10">
                                                    <input type="checkbox" id="switch-p-1" name="dias[]" value="domingo" >
                                                    <label for="switch-p-1" class="cr"></label>
                                                </div>
                                            </div>
                                            
                                            {!! Form::hidden('usuario_id', $id) !!}
                                            
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary"><span class="pcoded-micon"><i class="feather icon-save"></i></span><span class="pcoded-mtext">Guardar</span></button>
                                            </div>
                                            
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
@push('scripts')
<script src='{{asset("assets/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js")}}'></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[name=foto]').change(function(e) {

        var tgt = e.target || window.event.srcElement,
        files = tgt.files;

        var filename = files[0].name;
        var extension = files[0].type;
        var fileExtension = filename.split('.')[filename.split('.').length - 1].toLowerCase();   

        var file = $(this)[0].files[0];
        if (file) {
            {{-- orientation(file, function(base64img, value) {                
                console.log(rotation[value]);
                var rotated = $('#image_preview').attr('src', base64img);
                if (value) {
                    rotated.css('transform', rotation[value]);
                }
            }); --}}
        }            

        if (FileReader && files && files.length) {
            if (fileExtension === 'png' || fileExtension === 'jpeg' || fileExtension === 'jpg') {
                var fr = new FileReader();
                fr.onload = function () {
                    $("#foto_nueva").attr("src",fr.result);
                }
                fr.readAsDataURL(files[0]);   
            }else {
                alert('Formato de imagen inválido, solo se permite PNG, JPG o JPEG');
                $('input[name=foto]').val('');
            }         
        }        
    });
    $('.datepicker').datepicker({
        autoclose:true,
        format:'dd-mm-yyyy'
    });
})
</script>
@endpush
@push('styles')
<link href="{{asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
<script>
    var page = {
        bootstrap: 3
    };

    function swap_bs() {
        page.bootstrap = 3;
    }
</script>
<style>
    .datepicker>.datepicker-days {
        display: block;
    }

    ol.linenums {
        margin: 0 0 0 -8px;
    }
</style>
@endpush