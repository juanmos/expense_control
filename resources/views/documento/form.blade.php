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
                                    @if($documento!=null)
                                    <h5 class="m-b-10">Editar documento</h5>
                                    @else
                                    <h5 class="m-b-10">Nuevo documento</h5>
                                    @endif
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('institucion.show',$id)}}">Institución</a></li>
                                    @if($documento!=null)
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
                
                <form action="{{($documento!=null)?route('naturales.documentos.update',[$s->id]):route('naturales.documentos.store',$id)}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="_method" value="{{($documento!=null)?'PUT':'POST'}}"/>
                    {!! Form::hidden('institucion_id', $id) !!}
                    
                    
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del documento</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 ">
                                                <div>
                                                    <span class="btn btn-round btn-primary btn-file">
                                                        <span class="fileinput-new">Buscar foto</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                        {!! Form::file('foto',null,['class' => 'form-control']) !!} 
                                                    </span>
                                                    
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Borrar</a>
                                                </div>
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-circle" style="max-width:100%">
                                                        @if($documento!=null && $documento->foto != '')
                                                            <img id="foto_nueva" src="{{Storage::url($documento->foto)}}" border="0">
                                                        @else
                                                            <img id="foto_nueva" src="{{asset('images/default_user.png')}}" border="0">
                                                        @endif
                                                    </div>
                                                    <div id="image_preview" class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                                </div>
                                            </div>                                           
                                            <div class="form-group col-md-6 ">
                                                <label for="exampleInputEmail1">RUC/Cedula *</label>
                                                <input type="text" value="@if($documento!=null){{$documento->cliente->ruc}} @else{{old('ruc')}}@endif" name="ruc"  required="required" class="form-control buscaRUC" aria-describedby="emailHelp" placeholder="Cedula, RUC">
                                                <label for="exampleInputPassword1">Cliente *</label>
                                                <input type="text" value="@if($documento!=null){{$documento->cliente->nombre_comercial}} @else{{old('cliente_nombre')}}@endif" name="cliente_nombre"  required="required" class="form-control" id="nombre_cliente" placeholder="Nombre del cliente">
                                                <label for="exampleInputPassword1">Fecha *</label>
                                                <input type="text" value="@if($documento!=null){{$documento->fecha}} @else{{old('fecha')}}@endif" name="fecha"  required="required" class="form-control datepicker" id="exampleInputPassword1" placeholder="Fecha">
                                                @if($tipo=='compra')
                                                
                                                    <label for="exampleInputPassword1">Categoria de la compra</label>
                                                    {!! Form::select('categoria_id', $categorias, ($documento!=null)?$documento->categoria_id : 1 ,["class"=>"form-control"]) !!}
                                                
                                                @endif
                                                @if($tipo=='compra' || $tipo=='factura')
                                                <label for="exampleInputPassword1">Subtotal</label>
                                                <input type="text" value="@if($documento!=null){{$documento->subtotal}} @else{{old('subtotal')}}@endif" name="subtotal"  required="required" class="form-control" id="subtotal" placeholder="Subtotal">
                                                <label for="exampleInputPassword1">IVA</label>
                                                <input type="text" value="@if($documento!=null){{$documento->iva}} @else{{old('iva')}}@endif" name="iva" class="form-control" id="iva" placeholder="IVA">
                                                <label for="exampleInputPassword1">Propina</label>
                                                <input type="text" value="@if($documento!=null){{$documento->propina}} @else{{old('propina')}}@endif" name="propina"  class="form-control" id="propina" placeholder="Propina">
                                                <label for="exampleInputPassword1">Servicio</label>
                                                <input type="text" value="@if($documento!=null){{$documento->servicio}} @else{{old('servicio')}}@endif" name="servicio"  class="form-control" id="servicio" placeholder="Servicio">
                                                <label for="exampleInputPassword1">Total</label>
                                                <input type="text" value="@if($documento!=null){{$documento->total}} @else{{old('total')}}@endif" name="total" class="form-control" id="total" placeholder="Total">
                                                @elseif($tipo=='retencion')
                                                <label for="exampleInputPassword1">Retención en el IVA</label>
                                                <input type="text" value="@if($documento!=null){{$documento->ret_iva}} @else{{old('ret_iva')}}@endif" name="ret_iva" class="form-control" id="ret_iva" placeholder="Retención en el IVA">
                                                <label for="exampleInputPassword1">Retención en la renta</label>
                                                <input type="text" value="@if($documento!=null){{$documento->ret_renta}} @else{{old('ret_renta')}}@endif" name="ret_renta" class="form-control" id="ret_renta" placeholder="Retención en la renta">
                                                @endif
                                            </div>
                                            {!! Form::hidden('cliente_id', 0, ['id'=>'cliente_id']) !!}  
                                            {!! Form::hidden('documento', $tipo) !!}  
                                            
                                            <div class="form-group col-md-12">
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
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.0/dist/latest/bootstrap-autocomplete.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#subtotal').on('change',calculaTotal)
    $('#propina').on('change',calculaTotal)
    $('#servicio').on('change',calculaTotal)
    $('#iva').on('change',calculaTotal)

    function calculaTotal(){
        var total = parseFloat($('#subtotal').val() || 0)+
                    parseFloat($('#propina').val() || 0)+
                    parseFloat($('#servicio').val() || 0)+
                    parseFloat($('#iva').val() || 0);
        $('#total').val(total)
    }
    $('.buscaRUC').autoComplete({
        resolverSettings: {
            url: "{{route('naturales.clientes.find.cedula')}}"
        },
        minLength:6
    }).on('autocomplete.select', function (evt, item) {
        $('#nombre_cliente').val(item.text)
        $('#cliente_id').val(item.val);
        $('.buscaRUC').val(item.ruc);
    });;
    $('.datepicker').datepicker({
            autoclose:true,
            format:'dd-mm-yyyy'
        });
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