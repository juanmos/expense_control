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
                                    @if($usuario!=null)
                                    <h5 class="m-b-10">Editar usuario</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo usuario</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('empresa.usuario.index')}}">Usuario</a></li>
                                    @if($usuario!=null)
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
                @if($empresa!=null)
                    
                <form action="{{($usuario!=null)?route('empresa.usuario.update',[$usuario->id]):route('empresa.usuario.store')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="empresa_id" value="{{$empresa->id}}"/>
                @else
                <form action="{{($usuario!=null)?route('usuario.update',[$usuario->id]):route('usuario.store')}}" method="POST" enctype="multipart/form-data">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($usuario!=null)?'PUT':'POST'}}"/>
                    
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del usuario</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3 ">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-circle">
                                                        @if($usuario!=null && $usuario->foto != '')
                                                            <img id="foto_nueva" src="{{Storage::url($usuario->foto)}}" border="0">
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
                                           
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">Nombre *</label>
                                                <input type="text" value="@if($usuario!=null){{$usuario->nombre}} @else {{old('nombre')}} @endif" name="nombre"  required="required" class="form-control" aria-describedby="emailHelp" placeholder="Nombre">
                                                <label for="exampleInputPassword1">Apellido *</label>
                                                <input type="text" value="@if($usuario!=null){{$usuario->apellido}} @else {{old('apellido')}} @endif" name="apellido"  required="required" class="form-control" id="exampleInputPassword1" placeholder="Apellido">
                                            </div>
                                                @if ($errors->has('email'))
                                                    <div class="error">{{ $errors->first('email') }}</div>
                                                @endif
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Email *</label>
                                                <input type="email" value="@if($usuario!=null){{$usuario->email}} @else {{old('email')}} @endif" name="email" class="form-control" required="required" id="exampleInputPassword1" placeholder="Email" @if($usuario!=null && !Auth::user()->hasRole('Administrador')) readonly="readonly" @endif>
                                                @if ($errors->has('email'))
                                                    <div class="text-c-red">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Contraseña @if($usuario==null) * @else <small>Si escribe la contraseña se cambiara para el usuario</small> @endif</label>
                                                <input type="password" value="" name="password" class="form-control" @if($usuario==null) required="required" @endif id="exampleInputPassword1" placeholder="Contraseña">
                                                @if ($errors->has('password'))
                                                    <div class="text-c-red">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Teléfono</label>
                                                <input type="text" value="@if($usuario!=null){{$usuario->telefono}} @else {{old('telefono')}} @endif" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                            </div>
                                            @if($usuario!=null)
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Estado</label>
                                                {!! Form::select('activo', ["0"=>"Inactivo","1"=>"Activo"], ($usuario!=null)?$usuario->activo : 1 ,["class"=>"form-control"]) !!}
                                            </div>  
                                            @endif
                                            @if(!Auth::user()->hasRole('Vendedor'))
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">Rol</label>
                                                {!! Form::select('role', $roles, ($usuario!=null)?$usuario->getRoleNames()[0] : 1 ,["class"=>"form-control"]) !!}
                                            </div> 
                                            @endif
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