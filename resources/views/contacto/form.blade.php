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
                                    @if($contacto!=null)
                                    <h5 class="m-b-10">Editar contacto</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo contacto</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('cliente.index')}}">Contacto</a></li>
                                    @if($contacto!=null)
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
                
                <form action="{{($contacto!=null)?route('contacto.update',[$contacto->id]):route('contacto.store',$cliente_id)}}" method="POST" enctype="multipart/form-data">
                
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($contacto!=null)?'PUT':'POST'}}"/>
                    
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del contacto</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Nombre *</label>
                                                <input type="text" value="@if($contacto!=null){{$contacto->nombre}}@endif" name="nombre" class="form-control" aria-describedby="emailHelp" required="required" placeholder="Nombre">
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputPassword1">Apellido *</label>
                                                <input type="text" value="@if($contacto!=null){{$contacto->apellido}}@endif" name="apellido" class="form-control" id="exampleInputPassword1" required="required" placeholder="Apellido">
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email</label>
                                                <input type="email" value="@if($contacto!=null){{$contacto->email}}@endif" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Cargo</label>
                                                <input type="text" value="@if($contacto!=null){{$contacto->cargo}}@endif" name="cargo" class="form-control" id="exampleInputPassword1" placeholder="Cargo">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($contacto!=null){{$contacto->telefono}}@endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Extensión</label>
                                                <input type="text" value="@if($contacto!=null){{$contacto->extension}}@endif" name="extension" class="form-control" id="exampleInputPassword1" placeholder="Extensión">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Ciudad</label>
                                                {!! Form::select('ciudad_id', $ciudades, ($contacto!=null)?$contacto->ciudad_id : 1 ,["class"=>"form-control"]) !!}
                                            </div> 
                                            
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Oficina</label>
                                                {!! Form::select('oficina_id', $oficinas, ($contacto!=null)?$contacto->oficina_id : 1 ,["class"=>"form-control"]) !!}
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