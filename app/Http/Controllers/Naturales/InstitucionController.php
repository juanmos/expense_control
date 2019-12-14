<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Transaccion;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\CategoriaCompra;
use App\Models\EstadoInstitucion;
use App\Models\Configuracion;
use App\Models\TipoInstitucion;
use App\Models\DocumentoFisico;
use Carbon\Carbon;
use Crypt;
use Hash;
use Auth;
use DB;

class InstitucionController extends Controller
{
    public function index()
    {
        return redirect()->route('naturales.show', Auth::user()->institucion_id);
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
    public function show($id, $pest = 'V')
    {
        if ($pest==null) {
            $pest='V';
        }
        $institucion = Institucion::find($id);
        $alumnos = $institucion->alumnos()->whereHas('roles', function ($query) {
            $query->where('name', 'Alumno');
        })->with('roles')->get();
        $usuarios = $institucion->alumnos()->whereHas('roles', function ($query) {
            $query->whereIn('name', ['PersonaNatural']);
        })->with('roles')->get();
        $compras=[];
        $compras['dia']=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras['mes']=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras['ano']=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras['total']=$institucion->compras()
            ->get()->count();
        $ventas=[];
        $ventas['dia']=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $ventas['mes']=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $ventas['ano']=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $ventas['total']=$institucion->facturas()
            ->get()->count();
        $start=Carbon::now()->firstOfMonth()->format('d-m-Y');
        $end=Carbon::now()->format('d-m-Y');
        return view('naturales.show', compact(
            'institucion',
            'alumnos',
            'id',
            'start',
            'end',
            'compras',
            'ventas',
            'pest',
            'usuarios'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Institucion $naturale)
    {
        $institucion=$naturale;
        $paises = Pais::orderBy('pais')->get()->pluck('pais', 'id');
        $ciudad = Ciudad::orderBy('ciudad')->get()->pluck('ciudad', 'id');
        $estado = EstadoInstitucion::get()->pluck('estado', 'id');
        return view('naturales.form',compact('institucion','paises','ciudad','estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Institucion  $naturale)
    {
        $request->validate([
            'nombre'=>'required'
        ]);
        $naturale->update($request->all());
        return redirect()->route('naturales.show',$naturale->id);
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

    public function dashboard(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $fisicasCompras=$institucion->documentos()
                ->where('documento','compra')
                ->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
        $fisicasVentas=$institucion->documentos()
                ->where('documento','factura')
                ->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
        $electronicaCompras=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $electronicaVentas=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras=[];
        $compras['mes']=$electronicaCompras+$fisicasCompras;
        
        $ventas=[];
        $ventas['mes']=$electronicaVentas+$fisicasVentas;
        
        return Crypt::encrypt(json_encode(compact('compras', 'ventas')), false);
        // return response()->json( compact(
        //     'compras',
        //     'ventas'
        // ));
    }

    public function graficoComprasVentas(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $grafico=[];
        for($i=0;$i<6;$i++){
            $fisicasCompras=$institucion->documentos()
                ->where('documento','compra')
                ->whereBetween('fecha', [
                    Carbon::now()->subMonths($i)->firstOfMonth()->toDateString(),
                    Carbon::now()->subMonths($i)->endOfMonth()->toDateString()
                ])->get()->sum('total');
            $fisicasVentas=$institucion->documentos()
                ->where('documento','factura')
                ->whereBetween('fecha', [
                    Carbon::now()->subMonths($i)->firstOfMonth()->toDateString(),
                    Carbon::now()->subMonths($i)->endOfMonth()->toDateString()
                ])->get()->sum('total');
            $electronicaCompras=$institucion->compras()
                ->whereBetween('fecha', [
                    Carbon::now()->subMonths($i)->firstOfMonth()->toDateString(),
                    Carbon::now()->subMonths($i)->endOfMonth()->toDateString()
                ])
                ->get()->sum('total');
            $electronicaVentas=$institucion->facturas()
                ->whereBetween('fecha', [
                    Carbon::now()->subMonths($i)->firstOfMonth()->toDateString(),
                    Carbon::now()->subMonths($i)->endOfMonth()->toDateString()
                ])
                ->get()->sum('total');
            $grafico[]=[
                'fecha'=>now()->subMonths($i)->format('Y-m'),
                'ventas'=>number_format($electronicaVentas+$fisicasVentas,2,'.',''),
                'compras'=>number_format($electronicaCompras+$fisicasCompras,2,'.','')
            ];
        }        
        return Crypt::encrypt(json_encode(compact('grafico')), false);
    //     return response()->json( compact(
    //         'grafico'
    //     ));
    }

    public function graficoGastos(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $compras=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])->orderBy('categoria_id')
            ->groupBy('categoria_id')
            ->with('categoria')
            ->select(DB::raw('COUNT(*) AS totalCompras,categoria_id,SUM(total) as compras'))->get();
        $comprasFisicas=$institucion->documentos()
            ->where('documento','compra')
            ->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])->orderBy('categoria_id')
            ->groupBy('categoria_id')
            ->with('categoria')
            ->select(DB::raw('COUNT(*) AS totalCompras,categoria_id,SUM(total) as compras'))->get();
        
        $comprasJunto=$compras->concat($comprasFisicas)->mapToGroups(function ($item, $key) {
            return [$item->categoria->categoria => $item];
        });
        $compras=[];
        foreach($comprasJunto as $key=>$compra){
            $compras[]=[
                'totales'=>number_format($compra->sum('compras'),2,'.',''),
                'categoria'=>$key
            ];
        }
        
        return Crypt::encrypt(json_encode(compact('compras')), false);
        // return response()->json( compact(
        //     'compras'
        // ));
    }

    public function graficoGastosAnual(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $compras=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])->orderBy('categoria_id')
            ->groupBy('categoria_id')
            ->with('categoria')
            ->select(DB::raw('COUNT(*) AS totalCompras,categoria_id,SUM(total) as compras'))->get();
        $comprasFisicas=$institucion->documentos()
            ->where('documento','compra')
            ->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])->orderBy('categoria_id')
            ->groupBy('categoria_id')
            ->with('categoria')
            ->select(DB::raw('COUNT(*) AS totalCompras,categoria_id,SUM(total) as compras'))->get();
        
        $comprasJunto=$compras->concat($comprasFisicas)->mapToGroups(function ($item, $key) {
            return [$item->categoria->categoria => $item];
        });
        $compras=[];
        foreach($comprasJunto as $key=>$compra){
            $compras[]=[
                'totales'=>number_format($compra->sum('compras'),2,'.',''),
                'categoria'=>$key
            ];
        }
        
        return Crypt::encrypt(json_encode(compact('compras')), false);
        // return response()->json( compact(
        //     'compras'
        // ));
    }

    public function topVentas(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $ventas=$institucion->facturas()
            ->orderBy('total','desc')
            ->groupBy('cliente_id')
            ->with('cliente.cliente')
            ->select(DB::raw('COUNT(*) AS totalCompras,cliente_id,SUM(total) as total'))
            ->limit(10)->get();
        // return $ventas;
        return Crypt::encrypt(json_encode(compact('ventas')), false);
    }
    public function topCompras(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $compras=$institucion->compras()
            ->orderBy('total','desc')
            ->groupBy('cliente_id')
            ->with('cliente.cliente')
            ->select(DB::raw('COUNT(*) AS totalCompras,cliente_id,SUM(total) as total'))
            ->limit(10)->get();
        
        return Crypt::encrypt(json_encode(compact('compras')), false);
    }
}
