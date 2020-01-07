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
                                    <h5 class="m-b-10">Importar factura electrónica</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('naturales.facturas.index',auth()->user()->institucion_id)}}">Facturas</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Importar</a></li>
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Datos del menu</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputPassword1">XML de la factura</label>
                                                {!! Form::file('xml', ['class'=>'form-control','placeholder'=>'XML de la factura']) !!}
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Importar</button>
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