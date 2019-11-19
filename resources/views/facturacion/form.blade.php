@extends('layouts.app')

@section('content')
<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Factura</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('naturales.facturas.index',Auth::user()->institucion_id)}}">Facturas</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Nueva factura</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- [ Invoice ] start -->
                            <div class="container" id="printTable">
                                <div>
                                    <div class="card">
                                        {{-- <div class="row invoice-contact">
                                            <div class="col-md-8">
                                                <div class="invoice-box row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-responsive invoice-table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <td><img src="assets/images/logo-dark.png" class="m-b-10" alt=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{$factura->datos_facturacion->nombre}} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>1065 Mandan Road, Columbia MO, Missouri. (123)-65202</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">demo@gmail.com</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>+91 919-91-91-919</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div> --}}
                                        <div class="card-block">
                                            <div class="row invoive-info">
                                                <div class="col-md-4 col-xs-12 invoice-client-info">
                                                    <h6>Cliente :</h6>
                                                    @if($factura->cliente_id==null)
                                                    <div id="datosCliente" style="display:none">
                                                        <h6 class="m-0" id="cliente_nombre"></h6>
                                                        <p class="m-0 m-t-10" id="cliente_ruc"></p>
                                                        <p class="m-0" id="cliente_direccion"></p>
                                                        <p class="m-0" id="cliente_telefono"></p>
                                                        <p class="m-0" id="cliente_email"></p>
                                                        <p class="m-0" id="cliente_contacto"></p>
                                                        <div class="form-inline" style="display: none" id="cliente_email_div">
                                                        <label >Email:</label>
                                                        {!! Form::text('email_contacto', '', ['class'=>'form-control','id'=>'cliente_email_val','placeholder'=>'Ingrese el email para enviar la factura']) !!}
                                                        </div>
                                                    </div>
                                                    <a href="#" data-toggle="modal" data-target="#buscarClienteModal" class="btn btn-primary"><i class=""></i>Buscar cliente</a>
                                                    @else
                                                    <h6 class="m-0">{{$factura->datosFacturacion->nombre}}</h6>
                                                    <p class="m-0 m-t-10">{{$factura->datosFacturacion->ruc}}</p>
                                                    <p class="m-0">{{$factura->datosFacturacion->direccion}}</p>
                                                    <p class="m-0">{{$factura->datosFacturacion->telefono}}</p>
                                                    <p><a class="text-secondary"target="_top">{{$factura->datosFacturacion->email}}</a></p>
                                                    @endif
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <h6>Datos de factura :</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Fecha :</th>
                                                                <td>
                                                                    @if($factura->fecha==null)
                                                                    {{Carbon\Carbon::now()->format('d-m-Y')}}
                                                                    @else
                                                                    {{date('d-m-Y',strtotime($factura->fecha))}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Estado :</th>
                                                                <td>
                                                                    @if($factura->fecha==null)
                                                                    <span class="label label-danger">En creación</span>
                                                                    @else
                                                                    <span class="label @if($factura->estado_id==8) label-danger @else label-warning @endif">{{$factura->estado->estado}}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Forma de pago :</th>
                                                                <td>
                                                                    @if($factura->pago==null)
                                                                    {!! Form::select('forma_pago_id', $formaPago, 0, ['class'=>'form-control']) !!}
                                                                    @else
                                                                    {{$factura->pago->transaccion->forma_pago->forma_pago}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    @if($factura->clave!=null)
                                                    <h6 class="m-b-20">Datos de autorización</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Autorización :</th>
                                                                <td>{{$factura->clave}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Ambiente :</th>
                                                                <td>
                                                                    <span class="label @if($factura->ambiente==2) label-success @else label-warning @endif">{{($factura->ambiente==2)? 'Producción':'Pruebas' }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Numero :</th>
                                                                <td>
                                                                    {{$factura->factura_no}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <a href="#" data-toggle="modal" data-target="#modalProductos" class="btn btn-primary float-right">Ingresar items</a>
                                                        <table class="table  invoice-detail-table">
                                                            <thead>
                                                                <tr class="thead-default">
                                                                    <th>Descripción</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Precio Unitario</th>
                                                                    <th>Precio Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($factura->detalle as $detalle)
                                                                   <tr>
                                                                        <td>
                                                                            <h6>{{$detalle->descripcion}}</h6>
                                                                            <p>{{$detalle->codigo}}</p>
                                                                        </td>
                                                                        <td>{{$detalle->cantidad}}</td>
                                                                        <td>${{$detalle->precio_unitario}}</td>
                                                                        <td>${{$detalle->precio}}</td>
                                                                    </tr> 
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-responsive invoice-table invoice-total">
                                                        <tbody>
                                                            <tr>
                                                                <th>Sub Total :</th>
                                                                <td>${{$factura->subtotal}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>IVA (12%) :</th>
                                                                <td>${{$factura->iva}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Descuento :</th>
                                                                <td>${{$factura->descuento}}</td>
                                                            </tr>
                                                            <tr class="text-info">
                                                                <td>
                                                                    <hr />
                                                                    <h5 class="text-primary m-r-10">Total :</h5>
                                                                </td>
                                                                <td>
                                                                    <hr />
                                                                    <h5 class="text-primary">${{$factura->total}}</h5>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="col-sm-12">
                                                    <h6>Terms And Condition :</h6>
                                                    <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                                    </p>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    @if($factura->estado_id==2)
                                    <div class="row text-center">
                                        <div class="col-sm-12 invoice-btn-group text-center">
                                            <a href="{{route('institucion.facturacion.pdf',[$factura->institucion_id,$factura->id])}}" target="_blank" class="btn btn-primary btn-print-invoice m-b-10">Ver PDF</a>
                                            <a href="{{route('institucion.facturacion.xml',[$factura->institucion_id,$factura->id])}}" target="_blank" class="btn btn-secondary m-b-10 ">Ver XML</a>
                                            <a href="{{route('institucion.facturacion.email',[$factura->institucion_id,$factura->id])}}" target="_blank" class="btn btn-secondary m-b-10 ">Enviar por mail</a>
                                            <a href="{{route('institucion.facturacion.anular',[$factura->institucion_id,$factura->id])}}" target="_blank" class="btn btn-danger m-b-10 ">Anular</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- [ Invoice ] end -->
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade bd-example-modal-lg" id="buscarClienteModal" tabindex="-1" role="dialog" aria-labelledby="buscarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buscarClienteModalLabel">Buscar clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                 <div class="table-responsive">
                    <table id="clientesData" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Razón social</th>
                                <th>RUC/Cedula</th>
                                
                            </tr>
                        </thead>
                        <tbody id="entrydata">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" formaction="{{route('institucion.alumno.create',Auth::user()->institucion_id)}}">Nuevo alumno</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/data-tables/js/datatables.min.js")}}'></script>
<script>
$(function() {
    $('#clientesData').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 1, "asc" ]],
        ajax: "{!! route('naturales.clientes.data',$institucion_id) !!}",
        columnDefs: [
            { width: 200, targets: 0 }
        ],
        fixedColumns: true,
        columns: [
            // { data: 'id', name: 'id' },
            { "data": "id", render: function (dataField) { 
                var link='<a href="#" clienteId="'+dataField+'" data-dismiss="modal" class="label theme-bg2 text-white f-12 seleccionarCliente">Seleccionar</a>';
                    return link;
                } 
            },
            { data: 'cliente.razon_social', name: 'cliente.razon_social',width:'60%' },
            { data: 'cliente.ruc', name: 'cliente.ruc',width:'20%' },
            
        ],
    });
});
$(document).on('click','.seleccionarCliente',function(){
    var clienteId = $(this).attr('clienteId');
    $.get('{{url("naturales/naturales/".$institucion_id."/clientes/id/")}}/'+clienteId,function(json){
        $("#cliente_nombre").html(json.clientes.razon_social);
        $("#cliente_ruc").html('RUC: '+json.clientes.ruc);
        $("#cliente_direccion").html('Dir: '+json.clientes.direccion);
        $("#cliente_telefono").html('Telf: '+json.clientes.telefono);
        if(json.clientes.cliente_institucion.length>0){
            if(json.clientes.cliente_institucion[0].email!=null){
                $('#cliente_email_div').hide();
                $("#cliente_email").show();
                $("#cliente_email").html('Email: '+json.clientes.cliente_institucion[0].email);
            }else{
                $('#cliente_email_div').show();
                $("#cliente_email").hide();
            }
            
            $("#cliente_contacto").html((json.clientes.cliente_institucion[0].apellido!=null)?'Contacto: '+json.clientes.cliente_institucion[0].nombre+' '+json.clientes.cliente_institucion[0].apellido:'Contacto: '+json.clientes.cliente_institucion[0].nombre);
        }
        
        $('#datosCliente').show();
    },'json');
});
</script>
@endpush
@push('styles')
<link rel="stylesheet" href='{{asset("assets/plugins/data-tables/css/datatables.min.css")}}'>
@endpush