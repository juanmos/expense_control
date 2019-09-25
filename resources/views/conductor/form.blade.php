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
                                    @if($conductor!=null)
                                    <h5 class="m-b-10">Editar conductor</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo conductor</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('conductor.index')}}">Conductores</a></li>
                                    @if($conductor!=null)
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
                <form action="{{($conductor!=null)?route('conductor.update',$conductor->id):route('conductor.store')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($conductor!=null)?'PUT':'POST'}}"/>
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos personales</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3 ">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-circle">
                                                        @if($conductor!=null && $conductor->foto != '')
                                                            <img id="foto_nueva" src="{{Storage::url($conductor->foto)}}" border="0">
                                                        @else
                                                            <img id="foto_nueva" src="{{asset('images/default_user.png')}}" border="0">
                                                        @endif
                                                    </div>
                                                    <div id="image_preview" class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <div>
                                                    <span class="btn btn-round btn-primary btn-file">
                                                        <span class="fileinput-new">Buscar foto</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                        {!! Form::file('foto',null,['class' => 'form-control']) !!} 
                                                    </span>
                                                    <br />
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Nombre</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->nombre}}@endif" name="nombre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nombre">
                                            
                                                <label for="exampleInputPassword1">Apellido</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->apellido}}@endif" name="apellido" class="form-control" id="exampleInputPassword1" placeholder="Apellido">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="email" value="@if($conductor!=null){{$conductor->email}}@endif" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            {{-- <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Foto</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div> --}}
                                            @if($conductor!=null)
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Estado</label>
                                                {!! Form::select('activo', ["0"=>"Inactivo","1"=>"Activo"], ($conductor!=null)?$conductor->activo : 1 ,["class"=>"form-control"]) !!}
                                            </div>  
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Input group -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del vehículo</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Marca</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->conductor->marca}}@endif" name="marca" class="form-control" placeholder="Marca">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Modelo</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->conductor->modelo}}@endif" name="modelo" class="form-control" placeholder="Modelo">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Placa</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->conductor->placa}}@endif" name="placa" class="form-control" placeholder="Placa">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Color</label>
                                                <input type="text" value="@if($conductor!=null){{$conductor->conductor->color}}@endif" name="color" class="form-control" placeholder="Color">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Capacidad</label>
                                                <input type="number" value="{{($conductor!=null)?$conductor->conductor->capacidad:3}}" name="capacidad" class="form-control" placeholder="Capacidad">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Año</label>
                                                <input type="number" value="{{($conductor!=null)?$conductor->conductor->ano:2019}}" name="ano" class="form-control" placeholder="Año">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Tipo de vehículo</label>
                                                {!! Form::select('tipo_vehiculo_id', $tipos, ($conductor!=null)?$conductor->conductor->tipo_vehiculo_id : 1 ,["class"=>"form-control"]) !!}
                                            </div>  
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Vehículo propio</label>
                                                {!! Form::select('tipo_vehiculo_id', ['0'=>'No','1'=>'Si'], ($conductor!=null)?$conductor->conductor->propio : 1 ,["class"=>"form-control"]) !!}
                                            </div>  
                                            <button type="submit" class="btn btn-primary">Guardar</button>
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
})
</script>
@endpush
