<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\FacturaDetalle;
use App\Models\Factura;
use App\Models\FormaPago;
use App\Models\Cliente;
use App\Models\ClienteInstitucion;
use Carbon\Carbon;
use Crypt;
use Auth;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$institucion_id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $dia=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])->with('cliente.cliente')->get()->sum('total');
        $mes=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])->with('cliente.cliente')->get()->sum('total');
        $ano=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])->with('cliente.cliente')->get()->sum('total');
        $start=Carbon::now()->firstOfMonth()->format('d-m-Y');
        $end=Carbon::now()->format('d-m-Y');
        return view('facturacion.index', compact('institucion', 'institucion_id', 'dia', 'mes', 'ano', 'start', 'end'));
    }

    public function facturasData(Request $request, $institucion_id = null)
    {
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
            $dia=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->subDays(7)->toDateString(),
                    Carbon::now()->toDateString()
                ])->with('cliente.cliente')->get()->sum('total');
            $mes=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->with('cliente.cliente')->get()->sum('total');
            $ano=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->startOfYear()->toDateString(),
                    Carbon::now()->toDateString()
                ])->with('cliente.cliente')->get()->sum('total');
            $facturas=$institucion->facturas()->whereBetween('fecha', [$start,$end])
                        ->with('cliente.cliente')->orderBy('fecha', 'desc')->paginate(50);
            return Crypt::encrypt(json_encode(compact('dia', 'mes', 'ano', 'facturas')), false);
            
            // return json_encode(compact('dia', 'mes', 'ano', 'facturas'));
        }
        
        $facturas=$institucion->facturas()->whereBetween('fecha', [$start,$end])->with('cliente.cliente')->get();
        return Datatables::of($facturas)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id)
    {
        $factura=new Factura;
        $formaPago = FormaPago::whereIn('id',[1,2,3,4,5,6])->get()->pluck('forma_pago','id');
        return view('facturacion.form',compact('factura','formaPago','institucion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $institucion=Institucion::find(($request->is('api/*'))? base64_decode($id):$id);
        $cliente = $institucion->clientes()->where('cliente_id',$request->get('cliente_id'))->first();
        dd($cliente);
        $data=[
            'estado_id'=>1,
            'fecha'=>Carbon::now()->toDateString(),
            'subtotal'=>$request->get('subtotal'),
            'subtotal0'=>$request->get('subtotal0'),
            'propina'=>$request->get('propina'),
            'descuento'=>$request->get('descuento'),
            'iva'=>$request->get('iva'),
            'servicio'=>$request->get('servicio'),
            'total'=>$request->get('total'),
            'ambiente'=>$institucion->configuracion->configuraciones['ambiente_facturacion'],
            'institucion_id'=>Auth::user()->institucion_id,
            'cliente_id'=>$request->get('cliente_id'),
            'establecimiento'=>$institucion->configuracion->configuraciones['establecimiento'],
            'puntoEmision'=>$institucion->configuracion->configuraciones['punto'],
            'secuencia'=>str_pad($institucion->configuracion->configuraciones['secuencia'], 9, "0", STR_PAD_LEFT)
        ];
        return $data;
        $nuevaSecuencia = intval($institucion->configuracion->configuraciones['secuencia'])+1;
        $institucion->configuracion->configuraciones['secuencia']=$nuevaSecuencia;
        $institucion->configuracion->save();
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
