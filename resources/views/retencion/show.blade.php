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
                                    <h5 class="m-b-10">Documento de retención {{$retencione->comprobante_numero}}</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="url('/')"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('naturales.retenciones.index',Auth::user()->institucion_id)}}">Compra</a></li>
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
                                                    <h6>Datos del cliente:</h6>
                                                    <h6 class="m-0">{{$retencione->cliente->cliente->nombre_comercial}}</h6>
                                                    <p class="m-0 m-t-10">{{$retencione->cliente->cliente->ruc}}</p>
                                                    <p class="m-0">{{$retencione->cliente->cliente->direccion}}</p>
                                                    <p class="m-0">{{$retencione->cliente->cliente->telefono}}</p>
                                                    <a href="{{route('naturales.clientes.show',[Auth::user()->institucion_id,$retencione->cliente->id])}}" class="label theme-bg text-white f-12">Ver cliente</a> 
                                                    {{--  <p><a class="text-secondary" href="mailto:demo@gmail.com" target="_top">{{$factura->datosFacturacion->email}}</a></p>  --}}
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <h6>Datos de la retención :</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>Fecha :</th>
                                                                <td>{{date('d-m-Y',strtotime($retencione->fecha))}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Estado :</th>
                                                                <td>
                                                                    <span class="label label-success">AUTORIZADO</span>
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
                                                                <td>{{$retencione->claveAcceso}}</td>
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
                                                                    {{$retencione->comprobante_numero}}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if($retencione->impuestos)
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table  invoice-detail-table">
                                                            <thead>
                                                                <tr class="thead-default">
                                                                    <th>Impuesto</th>
                                                                    <th>Base imponible</th>
                                                                    <th>Porcentaje</th>
                                                                    <th>Valor</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                                @foreach ($retencione->impuestos as $detalle)
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            <h6>{{$detalle['nombreImpuesto']}}</h6>
                                                                        </td>
                                                                        <td>{{$detalle['baseImponible']}}</td>
                                                                        <td>${{$detalle['valorPorcentaje']}}</td>
                                                                        <td>${{$detalle['valor']}}</td>
                                                                    </tr> 
                                                                @endforeach
                                                                 
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    
                                    {{-- <div class="row text-center">
                                        <div class="col-sm-12 invoice-btn-group text-center">
                                            <a href="{{route('naturales.compras.pdf',[$retencione->institucion_id,$retencione->id])}}" target="_blank" class="btn btn-primary btn-print-invoice m-b-10">Descargar</a>
                                        </div>
                                    </div> --}}
                                    
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