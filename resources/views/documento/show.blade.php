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
                                    <h5 class="m-b-10">Documento físico de {{$documento->documento}}</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="url('/')"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{back()}}">Documentos</a></li>
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
                                                <div class="col-md-6 col-xs-12 invoice-client-info">
                                                    <img src="{{Storage::url($documento->foto)}}" width="100%" />
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <h6>Datos del documento :</h6>
                                                    <label for="exampleInputEmail1">RUC/Cedula *</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->cliente->ruc}} @else{{old('ruc')}}@endif" name="ruc"  required="required" readonly="readonly" class="form-control buscaRUC" aria-describedby="emailHelp" placeholder="Cedula, RUC">
                                                    <label for="exampleInputPassword1">Cliente *</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->cliente->nombre_comercial}} @else{{old('cliente_nombre')}}@endif" name="cliente_nombre"  required="required" class="form-control" id="nombre_cliente" placeholder="Nombre del cliente">
                                                    <label for="exampleInputPassword1">Fecha *</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->fecha}} @else{{old('fecha')}}@endif" name="fecha"  required="required" readonly="readonly" class="form-control datepicker" id="exampleInputPassword1" placeholder="Fecha">
                                                    @if($documento->documento=='compra')
                                                    
                                                        <label for="exampleInputPassword1">Categoria de la compra</label>
                                                        {!! Form::select('categoria_id', $categorias, ($documento!=null)?$documento->categoria_id : 1 ,["class"=>"form-control"]) !!}
                                                    
                                                    @endif
                                                    @if($documento->documento=='compra' || $documento->documento=='factura')
                                                    <label for="exampleInputPassword1">Subtotal</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->subtotal}} @else{{old('subtotal')}}@endif" name="subtotal" readonly="readonly"  required="required" class="form-control" id="subtotal" placeholder="Subtotal">
                                                    <label for="exampleInputPassword1">IVA</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->iva}} @else{{old('iva')}}@endif" name="iva" class="form-control" readonly="readonly" id="iva" placeholder="IVA">
                                                    <label for="exampleInputPassword1">Propina</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->propina}} @else{{old('propina')}}@endif" name="propina"  readonly="readonly" class="form-control" id="propina" placeholder="Propina">
                                                    <label for="exampleInputPassword1">Servicio</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->servicio}} @else{{old('servicio')}}@endif" name="servicio" readonly="readonly"  class="form-control" id="servicio" placeholder="Servicio">
                                                    <label for="exampleInputPassword1">Total</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->total}} @else{{old('total')}}@endif" name="total" readonly="readonly" class="form-control" id="total" placeholder="Total">
                                                    @elseif($documento->documento=='retencion')
                                                    <label for="exampleInputPassword1">Retención en el IVA</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->ret_iva}} @else{{old('ret_iva')}}@endif" name="ret_iva" readonly="readonly" class="form-control" id="ret_iva" placeholder="Retención en el IVA">
                                                    <label for="exampleInputPassword1">Retención en la renta</label>
                                                    <input type="text" value="@if($documento!=null){{$documento->ret_renta}} @else{{old('ret_renta')}}@endif" name="ret_renta" readonly="readonly" class="form-control" id="ret_renta" placeholder="Retención en la renta">
                                                    @endif
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="row text-center">
                                        <div class="col-sm-12 invoice-btn-group text-center">
                                            {!! Form::open(["route"=>['naturales.documentos.eliminar',$documento->id],"method"=>'POST']) !!}
                                            {!! Form::hidden('_method', "DELETE") !!}
                                            <button type="submit" target="_blank" class="btn btn-danger m-b-10">Eliminar</button>
                                            
                                            {!! Form::close() !!}
                                            
                                        </div>
                                    </div>
                                    
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