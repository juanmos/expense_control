<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Retencion;
use Carbon\Carbon;
use Crypt;
use Auth;

class RetencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $retenciones=$institucion->retenciones()->whereBetween('fecha', [
                now()->subDays(7)->toDateString(),
                now()->toDateString()
            ])->with('cliente.cliente')->get();
        $dia=['renta'=>0,'iva'=>0];
        foreach($retenciones as $retencion){
            foreach($retencion->impuestos as $impuesto){
                if($impuesto['nombreImpuesto']=='RENTA'){
                    $dia['renta']=$dia['renta']+$impuesto['valor'];
                }
                if($impuesto['nombreImpuesto']=='IVA'){
                    $dia['iva']=$dia['iva']+$impuesto['valor'];
                }
            }
        }
        $retenciones=$institucion->retenciones()->whereBetween('fecha', [
                now()->firstOfMonth()->toDateString(),
                now()->toDateString()
            ])->with('cliente.cliente')->get();
        $mes=['renta'=>0,'iva'=>0];
        foreach($retenciones as $retencion){
            foreach($retencion->impuestos as $impuesto){
                if($impuesto['nombreImpuesto']=='RENTA'){
                    $mes['renta']=$mes['renta']+$impuesto['valor'];
                }
                if($impuesto['nombreImpuesto']=='IVA'){
                    $mes['iva']=$mes['iva']+$impuesto['valor'];
                }
            }
        }
        $retenciones=$institucion->retenciones()->whereBetween('fecha', [
                now()->startOfYear()->toDateString(),
                now()->toDateString()
            ])->with('cliente.cliente')->get();
        $ano=['renta'=>0,'iva'=>0];
        foreach($retenciones as $retencion){
            foreach($retencion->impuestos as $impuesto){
                if($impuesto['nombreImpuesto']=='RENTA'){
                    $ano['renta']=$ano['renta']+$impuesto['valor'];
                }
                if($impuesto['nombreImpuesto']=='IVA'){
                    $ano['iva']=$ano['iva']+$impuesto['valor'];
                }
            }
        }
        
        $start=now()->firstOfMonth()->format('d-m-Y');
        $end=now()->format('d-m-Y');
        return view('retencion.index', compact('institucion', 'institucion_id', 'dia', 'mes', 'ano', 'start', 'end'));
    }

    public function retencionesData(Request $request){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $start=Carbon::now()->firstOfMonth()->toDateString();
        $end=Carbon::now()->toDateString();
        if ($request->has('start_date')) {
            $start=Carbon::parse($request->get('start_date'))->toDateString();
        }
        if ($request->has('end_date')) {
            $end=Carbon::parse($request->get('end_date'))->toDateString();
        }
        if ($request->is('api/*')) {
            
            $retenciones=$institucion->retenciones()->whereBetween('fecha', [$start,$end])
                        ->with(['cliente.cliente'])->orderBy('fecha', 'desc')->paginate(50);
            return Crypt::encrypt(json_encode(compact('retenciones')), false);
        }
        
        $retenciones=$institucion->retenciones()->whereBetween('fecha', [$start,$end])->with('cliente.cliente')->get();
        return Datatables::of($retenciones)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
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
