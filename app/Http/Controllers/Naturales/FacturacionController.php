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
use App\Jobs\CrearFacturaPDFJob;
use App\Mail\ReenviarFacturaMail;
use Carbon\Carbon;
use SimpleXMLElement;
use Crypt;
use Auth;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $institucion_id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $dia=$institucion->facturas()
            ->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])->get()->sum('total');
        $diaFisica=$institucion->documentos()->where('documento', 'factura')
            ->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])->get()->sum('total');
        $dia+=$diaFisica;

        $mes=$institucion->facturas()
            ->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])->get()->sum('total');
        $mesFisica=$institucion->documentos()->where('documento', 'factura')
            ->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])->get()->sum('total');
        $mes+=$mesFisica;

        $ano=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])->get()->sum('total');
        $anoFisica=$institucion->documentos()->where('documento', 'factura')
            ->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])->get()->sum('total');
        $ano+=$anoFisica;

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
                ])->get()->sum('total');
            $mes=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $ano=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->startOfYear()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $facturas=$institucion->facturas()->whereBetween('fecha', [$start,$end])
                        ->with(['cliente.cliente','estado','detalle'])->orderBy('fecha', 'desc')->paginate(50);
            return Crypt::encrypt(json_encode(compact('dia', 'mes', 'ano', 'facturas')), false);
            
            // return json_encode(compact('dia', 'mes', 'ano', 'facturas'));
        }
        
        $facturas=$institucion->facturas()->whereBetween('fecha', [$start,$end])->with(['cliente.cliente','estado'])->get();
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
        $formaPago = FormaPago::whereIn('id', [1,2,3,4,5,6])->get()->pluck('forma_pago', 'id');
        return view('facturacion.form', compact('factura', 'formaPago', 'institucion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $detalles=json_decode($request->detalles);
        $institucion=Institucion::find(($request->is('api/*'))? base64_decode($id):$id);
        $cliente = $institucion->clientes()->where('cliente_id', $request->get('cliente_id'))->first();
        if ($cliente==null) {
            $elCliente= Cliente::find($request->get('cliente_id'));
            $cliente = $institucion->clientes()->create([
                'cliente_id'=>$request->get('cliente_id'),
                'nombre'=>$elCliente->nombre_comercial,
                'email'=>$request->email
            ]);
        } elseif ($cliente->email==null) {
            $cliente->email=$request->email;
            $cliente->save();
        }
        
        $data=[
            'estado_id'=>1,
            'pago_id'=>0,
            'datos_facturacion_id'=>0,
            'factura_no'=>'00',
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
            'cliente_id'=>$cliente->id,
            'establecimiento'=>$institucion->configuracion->configuraciones['establecimiento'],
            'puntoEmision'=>$institucion->configuracion->configuraciones['punto'],
            'secuencia'=>str_pad($institucion->configuracion->configuraciones['secuencia'], 9, "0", STR_PAD_LEFT)
        ];
        $factura=$institucion->facturas()->create($data);
        $factura->factura_no=$factura->factura_numero;
        $factura->save();
        $nuevaSecuencia = intval($institucion->configuracion->configuraciones['secuencia'])+1;
        $configuraciones = $institucion->configuracion->configuraciones;
        $configuraciones['secuencia']=$nuevaSecuencia;
        $institucion->configuracion->update([
            'configuraciones'=>$configuraciones
        ]);
        foreach ($detalles as $index => $detalle) {
            $factura->detalle()->create([
                'codigo'=>$index+1,
                'descripcion'=>$detalle->descripcion,
                'cantidad'=>$detalle->cantidad,
                'precio_unitario'=>$detalle->precio_u,
                'descuento'=>0,
                'iva'=>$detalle->iva,
                'precio'=>$detalle->precio_total
            ]);
        }
        return ($request->is('api/*'))?
                            response()->json(['creado'=>true]):
                            redirect()->route('naturales.facturas.index', $institucion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($institucion_id, $id)
    {
        $factura = Factura::find($id);
        return view('facturacion.factura', compact('factura'));
    }

    public function ventasCliente(Request $request, $cliente_id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        if ($request->is('api/*')) {
            $facturas=$institucion->facturas()->where('cliente_id', base64_decode($cliente_id))
                            ->with(['cliente.cliente','estado','detalle'])->orderBy('fecha', 'desc')->paginate(50);
            return Crypt::encrypt(json_encode(compact('facturas')), false);
        }
        
        $facturas=$institucion->facturas()->where('cliente_id', $cliente_id)
                            ->with(['cliente.cliente','estado','detalle'])->orderBy('fecha', 'desc')->get();
        return Datatables::of($facturas)->make(true);
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

    public function reenviarMail(Factura $factura)
    {
        ReenviarFacturaMail
    }

    public function import()
    {
        return view('facturacion.importar');
    }

    public function uploadXML(Request $request)
    {
        $request->validate([
            'xml'=>'required'
        ]);
        if ($request->has('xml')) {
            $xml_doc = $request->file('xml')->store('public/xml/'.auth()->user()->institucion_id);
            $xml = simplexml_load_file(storage_path("app/".$xml_doc));
            $json = json_encode($xml);
            $array = json_decode($json, true);
            $cliente=Cliente::where('ruc', $array['infoFactura']['identificacionComprador'])->first();
            if ($cliente == null) {
                $cliente=Cliente::create([
                    'ruc'=> $array['infoFactura']['identificacionComprador'],
                    'razon_social'=> utf8_decode($array['infoFactura']['razonSocialComprador']),
                    'nombre_comercial'=> utf8_decode($array['infoFactura']['razonSocialComprador']),
                    'direccion'=>utf8_decode($array['infoFactura']['dirEstablecimiento']),
                ]);
                $clienteInstitucion = $cliente->clienteInstitucion()->create([
                    'institucion_id' => auth()->user()->institucion_id,
                    'nombre'=>$cliente->nombre_comercial
                ]);
            } else {
                $clienteInstitucion = ClienteInstitucion::where('cliente_id', $cliente->id)->first();
                if ($clienteInstitucion == null) {
                    $clienteInstitucion = $cliente->clienteInstitucion()->create([
                        'institucion_id' => auth()->user()->institucion_id,
                        'nombre'=>$cliente->nombre_comercial
                    ]);
                }
            }
            
            $iva=array_reduce($array['infoFactura']['totalConImpuestos'], function ($carry, $item) {
                if (count($item) == count($item, COUNT_RECURSIVE)) {
                    $carry += $item['valor'];
                } else {
                    foreach ($item as $it) {
                        $carry+= $it['valor'];
                    }
                }
                return $carry;
            });

            $sub=0;
            $sub0=0;

            $factura=Factura::create([
                'cliente_id'=>$clienteInstitucion->id,
                'estado_id'=>2,
                'pago_id'=>1,
                'factura_no'=>"{$array['infoTributaria']['estab']}-{$array['infoTributaria']['ptoEmi']}-{$array['infoTributaria']['secuencial']}",
                'fecha'=>Carbon::createFromFormat('d/m/Y', $array['infoFactura']['fechaEmision'])->toDateString(),
                'establecimiento'=>$array['infoTributaria']['estab'],
                'puntoEmision'=>$array['infoTributaria']['ptoEmi'],
                'secuencia'=>$array['infoTributaria']['secuencial'],
                'subtotal'=>$sub,
                'subtotal0'=>$sub0,
                'propina'=>$array['infoFactura']['propina'],
                'descuento'=>$array['infoFactura']['totalDescuento'],
                'servicio'=>0,
                'iva'=>$iva,
                'total'=>$array['infoFactura']['importeTotal'],
                'clave'=>$array['infoTributaria']['claveAcceso'],
                'autorizacion'=>$array['infoTributaria']['claveAcceso'],
                'ambiente'=>2,
                'xml'=>$xml_doc,
                'institucion_id'=>auth()->user()->institucion_id
            ]);
           
            $isArrayOfArrays = array_filter($array['detalles']['detalle'], 'is_array') === $array['detalles']['detalle'];
            if ($isArrayOfArrays) {
                foreach ($array['detalles']['detalle'] as $detalle) {
                    $iva = 0;
                    foreach ($detalle['impuestos'] as $impuesto) {
                        if ($impuesto['codigoPorcentaje'] == 2) {
                            $iva=1;
                            $sub += $impuesto['baseImponible'];
                        } elseif ($impuesto['codigoPorcentaje'] == 0) {
                            $sub0 += $impuesto['baseImponible'];
                        }
                    }
                    

                    $factura->detalle()->create([
                        'codigo'=>$detalle['codigoPrincipal'],
                        'descripcion'=>utf8_decode($detalle['descripcion']),
                        'cantidad'=>$detalle['cantidad'],
                        'precio_unitario'=>$detalle['precioUnitario'],
                        'descuento'=>$detalle['descuento'],
                        'iva'=>$iva,
                        'precio'=>$detalle['precioTotalSinImpuesto'],
                    ]);
                }
            } else {
                foreach ($array['detalles'] as $detalle) {
                    $iva = 0;
                    foreach ($detalle['impuestos'] as $impuesto) {
                        if ($impuesto['codigoPorcentaje'] == 2) {
                            $iva=1;
                            $sub += $impuesto['baseImponible'];
                        } elseif ($impuesto['codigoPorcentaje'] == 0) {
                            $sub0 += $impuesto['baseImponible'];
                        }
                    }
                    $factura->detalle()->create([
                        'codigo'=>$detalle['codigoPrincipal'],
                        'descripcion'=>$detalle['descripcion'],
                        'cantidad'=>$detalle['cantidad'],
                        'precio_unitario'=>$detalle['precioUnitario'],
                        'descuento'=>$detalle['descuento'],
                        'iva'=>$iva,
                        'precio'=>$detalle['precioTotalSinImpuesto'],
                    ]);
                }
            }

            
            
            $factura->subtotal=$sub;
            $factura->subtotal0=$sub0;
            $factura->save();
            CrearFacturaPDFJob::dispatch($factura);
            return redirect()->route('naturales.facturas.index', Auth::user()->institucion_id);
        }
    }
}
