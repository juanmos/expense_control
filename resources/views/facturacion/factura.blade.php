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
                                    <h5 class="m-b-10">Factura {{$factura->factura_no}}</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#!">Factura</a></li>
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
                                                    <h6 class="m-0">{{$factura->datos_facturacion->nombre}}</h6>
                                                    <p class="m-0 m-t-10">{{$factura->datos_facturacion->ruc}}</p>
                                                    <p class="m-0">{{$factura->datos_facturacion->direccion}}</p>
                                                    <p class="m-0">{{$factura->datos_facturacion->telefono}}</p>
                                                    <p><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">{{$factura->datos_facturacion->email}}</a></p>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <h6>Datos de factura :</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Fecha :</th>
                                                                <td>{{date('d-m-Y',strtotime($factura->fecha))}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Estado :</th>
                                                                <td>
                                                                    <span class="label @if($factura->estado_id==8) label-danger @else label-warning @endif">{{$factura->estado->estado}}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Forma de pago :</th>
                                                                <td>
                                                                    {{($factura->pago)?$factura->pago->transaccion->forma_pago->forma_pago:''}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
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
@endsection