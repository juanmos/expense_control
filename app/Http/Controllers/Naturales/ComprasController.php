<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\CategoriaCompra;
use App\Models\Institucion;
use App\Models\Compra;
use App\Models\Cliente;
use Carbon\Carbon;
use Crypt;
use Auth;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $institucion_id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $dia=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])->with('cliente.cliente')->get()->sum('total');
        $mes=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])->with('cliente.cliente')->get()->sum('total');
        $ano=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])->with('cliente.cliente')->get()->sum('total');
        $start=Carbon::now()->firstOfMonth()->format('d-m-Y');
        $end=Carbon::now()->format('d-m-Y');
        return  view('compras.index', compact('institucion', 'institucion_id', 'dia', 'mes', 'ano', 'start', 'end'));
    }


    public function comprasData(Request $request, $institucion_id = null)
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
            $dia=$institucion->compras()->whereBetween('fecha', [
                    Carbon::now()->subDays(7)->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $mes=$institucion->compras()->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $ano=$institucion->compras()->whereBetween('fecha', [
                    Carbon::now()->startOfYear()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $compras=$institucion->compras()->whereBetween('fecha', [$start,$end])
                        ->with(['cliente.cliente','categoria'])->orderBy('fecha', 'desc')->paginate(50);
            return Crypt::encrypt(json_encode(compact('dia', 'mes', 'ano', 'compras')), false);
            
            // return json_encode(compact('dia', 'mes', 'ano', 'compras'));
        }
        
        $compras=$institucion->compras()->whereBetween('fecha', [$start,$end])->with('cliente.cliente')->get();
        return Datatables::of($compras)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($institucion_id, $id)
    {
        $compra = Compra::find($id);
        $detalle = $compra->detalles['detalle'];
        unset($detalle['impuestos']);
         
        $multiple=false;
        if (!(count($detalle) == count($detalle, COUNT_RECURSIVE))) {
            $multiple=true;
        }
        $categorias = CategoriaCompra::orderBy('categoria')->get();
        
        return view('compras.show', compact('compra', 'multiple', 'categorias'));
    }

    public function comprasCliente(Request $request, $cliente_id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        if($request->is('api/*')){
            $compras=$institucion->compras()->where('cliente_id', base64_decode($cliente_id))
                            ->with(['cliente.cliente','categoria'])->orderBy('fecha', 'desc')->paginate(50);
            // return $compras;
            return Crypt::encrypt(json_encode(compact('compras')), false);
        }
        $compras=$institucion->compras()->where('cliente_id', $cliente_id)
                            ->with(['cliente.cliente','categoria'])->orderBy('fecha', 'desc')->get();
        return Datatables::of($compras)->make(true);
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
        $compra=Compra::find(($request->is('api/*'))?base64_decode($id):$id);
        $compra->categoria_id=$request->get('categoria_id');
        $compra->save();
        $cliente = Cliente::find($compra->cliente->cliente_id);
        if ($cliente != null && $cliente->categoria_id==1) {
            $cliente->categoria_id=$request->get('categoria_id');
            $cliente->save();
        }
        return ($request->is('api/*'))? response()->json(['creado'=>true]):back()->with(['mensaje'=>'Categoria asignada']);
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

    public function pdf(Request $request, $institucion, $id)
    {
        $factura = Compra::find($id);
        return response()->file(storage_path('app/'.$factura->pdf));
    }

    public function actualziarSRI(){
        ObtenerComprasAnterioresJob::dispatch(Institucion::find(Auth::user()->institucion_id))->delay(1);;
        return response()->json(['obteniendo'=>true]);
    }
}
