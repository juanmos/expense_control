<?php

namespace App\Http\Controllers\Institucion;

use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Refrigerio;
use App\Models\TipoRefrigerio;
use App\Models\Pago;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Crypt;

class RefrigerioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::user()->institucion_id;
        $institucion = Institucion::find($id);
        
       // dd($alumnos);
        return view('alumno.index', compact('institucion', 'id'));
    }

    public function refrigeriosData(Request $request)
    {
        
        $id=Auth::user()->institucion_id;
        $institucion = Institucion::find($id);
        if ($request->is('api/*')) {
            $alumnos = $institucion->alumnos()->has('refrigerio')->whereHas('roles', function ($query) {
                $query->where('name', 'Alumno');
            })->with('alumno', 'refrigerio.tipoRefrigerio')->orderBy('apellido')->paginate(50);
            return response()->json(compact('alumnos'));
        }
        $alumnos = $institucion->alumnos()->has('refrigerio')->whereHas('roles', function ($query) {
            $query->where('name', 'Alumno');
        })->with('alumno', 'refrigerio.tipoRefrigerio')->get();
        return Datatables::of($alumnos)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $usuario =User::find($id);
        $refrigerio=null;
        $tipos=TipoRefrigerio::orderBy('tipo')->get()->pluck('tipo', 'id');
        return view('refrigerio.form', compact('usuario', 'tipos', 'id', 'refrigerio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = User::find(
            ($request->is('api/*'))? base64_decode($request->get('usuario_id')) :$request->get('usuario_id')
        );
        $tipo=TipoRefrigerio::find($request->get('tipo_refrigerio_id'));
        if ($request->is('api/*')) {
            $dias=explode(',', $request->get('dias'));
        } else {
            $dias=array_values($request->get('dias'));
        }
        if ($tipo->forma_pago=='diario') {
            $costo=$tipo->costo*count($dias);
        } else {
            $costo=$tipo->costo;
        }
        $usuario->refrigerio()->create([
            'tipo_refrigerio_id'=>$request->get('tipo_refrigerio_id'),
            'dias'=>$dias,
            'institucion_id'=>Auth::user()->institucion_id,
            'fecha_inicio'=>Carbon::parse($request->get('fecha_inicio'))->toDateString(),
            'fecha_fin'=>Carbon::parse($request->get('fecha_fin'))->toDateString(),
            'costo'=>$costo
        ]);
        if ($request->is('api/*')) {
            return response()->json(['creado'=>true]);
        }
        return redirect()->route('institucion.alumno.show', [Auth::user()->institucion_id,$usuario->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refigerio = Refrigerio::find($id);
        return response()->json($refigerio);
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
        $refrigerio = Refrigerio::find(($request->is('api/*'))? base64_decode($id) :$id);
        $tipos=TipoRefrigerio::find($request->get('tipo_refrigerio_id'));
        $dias=($request->is('api/*'))?explode(',', $request->get('dias')):array_values($request->get('dias'));
        
        $costo=$tipos->costo*count($dias);
        $refrigerio->update([
            'tipo_refrigerio_id'=>$request->get('tipo_refrigerio_id'),
            'dias'=>$dias,
            'fecha_inicio'=>Carbon::parse($request->get('fecha_inicio'))->toDateString(),
            'fecha_fin'=>Carbon::parse($request->get('fecha_fin'))->toDateString(),
            'costo'=>$costo
        ]);
        if ($request->is('api/*')) {
            return response()->json(['editado'=>true]);
        }
        return redirect()->route('institucion.alumno.show', [Auth::user()->institucion_id,$refrigerio->userable_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $refrigerio = Refrigerio::find(($request->is('api/*'))? base64_decode($id) :$id);
        $refrigerio->delete();
        if ($request->is('api/*')) {
            return response()->json(['eliminado'=>true]);
        }
        return back();
    }

    public function refrigerios($id)
    {
        $user = User::find(base64_decode($id));
        $refrigerios = $user->refrigerio()->with(['tipo_refrigerio'])->paginate(50);
        // return response()->json(compact('refrigerios'));
        return Crypt::encrypt(json_encode(compact('refrigerios')), false);
    }

    public function historialPagos(Request $request, $id)
    {
        $pagos=Pago::where(
            'refrigerio_id',
            ($request->is('api/*'))?base64_decode($id) :$id
        )
                    ->with(['transaccion.transaccion_relacionada','factura'])->get();
        if ($request->is('api/*')) {
            return Crypt::encrypt(json_encode(compact('pagos')), false);
        }
        return response()->json(compact('pagos'));
    }
}
