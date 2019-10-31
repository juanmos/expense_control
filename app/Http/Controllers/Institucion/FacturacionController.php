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
use Storage;
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
        $data=$request->except(['_token','pago_id','datos_factura_id']);
        if($request->get('datos_factura_id')==0){
            $datosFacturacion = DatosFacturacion::create($data);
        }else{
            $datosFacturacion = DatosFacturacion::find('datos_factura_id');
        }
        
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
            'precio'=>$pago->transaccion->valor 
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
        $factura = Factura::find($id);
        return view('facturacion.factura',compact('factura'));
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

    public function pdf($institucion,$id)
    {
        $factura = Factura::find($id);
        return response()->file(storage_path('app/'.$factura->pdf));
    }

    public function xml($institucion,$id)
    {
        $factura = Factura::find($id);
        return response()->download(storage_path('app/'.$factura->xml));
    }

    public function email($institucion,$id)
    {
        //
    }

    public function anular($institucion,$id)
    {
        //
    }
}
