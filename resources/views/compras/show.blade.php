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
                                    <h5 class="m-b-10">Factura de compra {{$compra->factura_numero}}</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="url('/')"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('naturales.compras.index',Auth::user()->institucion_id)}}">Compra</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Detalle</a></li>
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
                                        
                                        <div class="card-block">
                                            <div class="row invoive-info">
                                                <div class="col-md-4 col-xs-12 invoice-client-info">
                                                    <h6>Vendedor :</h6>
                                                    <h6 class="m-0">{{$compra->cliente->cliente->razon_social}}</h6>
                                                    <p class="m-0 m-t-10">{{$compra->cliente->cliente->ruc}}</p>
                                                    <p class="m-0">{{$compra->cliente->cliente->direccion}}</p>
                                                    <p class="m-0">{{$compra->cliente->cliente->telefono}}</p>
                                                    {{--  <p><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">{{$factura->datosFacturacion->email}}</a></p>  --}}
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <h6>Datos de factura :</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Fecha :</th>
                                                                <td>{{date('d-m-Y',strtotime($compra->fecha))}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Estado :</th>
                                                                <td>
                                                                    <span class="label label-success">AUTORIZADO</span>
                                                                </td>
                                                            </tr>
                                                            {{--  <tr>
                                                                <th>Forma de pago :</th>
                                                                <td>
                                                                    {{($factura->pago)?$factura->pago->transaccion->forma_pago->forma_pago:''}}
                                                                </td>
                                                            </tr>  --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <h6 class="m-b-20">Datos de autorización</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Autorización :</th>
                                                                <td>{{$compra->claveAcceso}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Ambiente :</th>
                                                                <td>
                                                                    <span class="label label-success">Producción</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Numero :</th>
                                                                <td>
                                                                    {{$compra->factura_numero}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if($compra->sincronizado)
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
                                                                @if ($multiple==false) 
                                                                    <tr>
                                                                        <td>
                                                                            <h6>{{$compra->detalles['detalle']['descripcion']}}</h6>
                                                                        </td>
                                                                        <td>{{$compra->detalles['detalle']['cantidad']}}</td>
                                                                        <td>${{$compra->detalles['detalle']['precioUnitario']}}</td>
                                                                        <td>${{$compra->detalles['detalle']['precioTotalSinImpuesto']}}</td>
                                                                    </tr> 
                                                                
                                                                @else
                                                                    @foreach ($compra->detalles['detalle'] as $detalle)
                                                                    
                                                                    <tr>
                                                                            <td>
                                                                                <h6>{{$detalle['descripcion']}}</h6>
                                                                            </td>
                                                                            <td>{{$detalle['cantidad']}}</td>
                                                                            <td>${{$detalle['precioUnitario']}}</td>
                                                                            <td>${{$detalle['precioTotalSinImpuesto']}}</td>
                                                                        </tr> 
                                                                    @endforeach
                                                                @endif   
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-responsive invoice-table invoice-total">
                                                        <tbody>
                                                            <tr>
                                                                <th>Sub Total :</th>
                                                                <td>${{$compra->totalSinImpuestos}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Propina :</th>
                                                                <td>${{$compra->propina}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>IVA (12%) :</th>
                                                                <td>${{array_reduce($compra->impuestos,function ($carry, $item)
                                                                    {
                                                                        $carry += $item['valor'];
                                                                        return $carry;
                                                                    })}}</td>
                                                            </tr>
                                                            {{--  <tr>
                                                                <th>Descuento :</th>
                                                                <td>${{$compra->descuento}}</td>
                                                            </tr>  --}}
                                                            <tr class="text-info">
                                                                <td>
                                                                    <hr />
                                                                    <h5 class="text-primary m-r-10">Total :</h5>
                                                                </td>
                                                                <td>
                                                                    <hr />
                                                                    <h5 class="text-primary">${{$compra->total}}</h5>
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
                                    @if($compra->sincronizado)
                                    <div class="row text-center">
                                        <div class="col-sm-12 invoice-btn-group text-center">
                                            <a href="{{route('naturales.compras.pdf',[$compra->institucion_id,$compra->id])}}" target="_blank" class="btn btn-primary btn-print-invoice m-b-10">Ver PDF</a>
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