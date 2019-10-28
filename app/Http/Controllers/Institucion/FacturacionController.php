<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DatosFacturacion;
use App\Models\FacturaDetalle;
use App\Models\Configuracion;
use App\Models\Refrigerio;
use App\Models\Factura;
use App\Models\Pago;
use Carbon\Carbon;
use Auth;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['_token','pago_id']);
        $datosFacturacion = DatosFacturacion::create($data);
        $configuracion = Configuracion::where('institucion_id',Auth::user()->institucion_id)->first();
        $secuencia = $configuracion->configuraciones['establecimiento'].'-'.$configuracion->configuraciones['punto'].'-'.str_pad($configuracion->configuraciones['secuencia'], 9, "0", STR_PAD_LEFT);
        $nuevaSecuencia = intval($configuracion->configuraciones['secuencia'])+1;
        $configuraciones = $configuracion->configuraciones;
        $configuraciones['secuencia']=$nuevaSecuencia;
        $configuracion->configuraciones=$configuraciones;
        $configuracion->save();
        $pago = Pago::find($request->get('pago_id'));
        $factura = Factura::create([
            'datos_facturacion_id'=>$datosFacturacion->id,
            'pago_id'=>$pago->id,
            'estado_id'=>1,
            'factura_no'=>$secuencia,
            'fecha'=>Carbon::now()->toDateString(),
            'subtotal'=>$pago->transaccion->valor,
            'subtotal0'=>0,
            'propina'=>0,
            'descuento'=>0,
            'servicio'=>0,
            'iva'=>($pago->transaccion->valor * 0.12),
            'total'=>$pago->transaccion->valor * 1.12
        ]);
        $factura->detalle()->create([
            'codigo'=>1,
            'descripcion'=>'Servicio de refrigerio: ',
            'cantidad'=>1,
            'precio_unitario'=>$pago->transaccion->valor,
            'descuento'=>0,
            'iva'=>($pago->transaccion->valor * 0.12),
            'precio'=>$pago->transaccion->valor * 1.12
        ]);
        return back()->with(['mensaje'=>'Factura creada']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
