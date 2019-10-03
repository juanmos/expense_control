<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Transaccion;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\EstadoInstitucion;
use Carbon\Carbon;
use Hash;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instituciones = Institucion::orderBy('nombre')->paginate(50);
        return view('institucion.index',compact('instituciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institucion = null;
        $paises = Pais::orderBy('pais')->get()->pluck('pais','id');
        $ciudad = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        $estado = EstadoInstitucion::get()->pluck('estado','id');
        return view('institucion.form',compact('institucion','ciudad','estado','paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $institucion = Institucion::create($request->all());
        $institucion->configuracion()->create();
        return redirect('admin/institucion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$pest=null)
    {
        if($pest==null)$pest='E';
        $institucion = Institucion::find($id);
        $alumnos = $institucion->alumnos()->whereHas('roles',function($query){
            $query->where('name','Alumno');
        })->with('roles')->get();
        $usuarios = $institucion->alumnos()->whereHas('roles',function($query){
            $query->whereIn('name',['Institucion','Institucion-operador']);
        })->with('roles')->get();
        $transacciones = $institucion->transacciones()->orderBy('fecha_hora','desc')->paginate(50);
        $hoy = Carbon::now()->toDateTimeString();
        $menos30 =Carbon::now()->subDays(30)->toDateString().' 00:00:00';
        $recargas =$institucion->transacciones()->whereBetween('fecha_hora',[$menos30,$hoy])
                                ->where('tipo_transaccion_id',2)->get();
        $compras =$institucion->transacciones()->whereBetween('fecha_hora',[$menos30,$hoy])
                                ->where('tipo_transaccion_id',1)->get();
        return view('institucion.show',compact('institucion','alumnos','id','transacciones','compras','recargas','pest','usuarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institucion = Institucion::find($id);
        $paises = Pais::orderBy('pais')->get()->pluck('pais','id');
        $ciudad = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        $estado = EstadoInstitucion::get()->pluck('estado','id');
        return view('institucion.form',compact('institucion','ciudad','estado','paises'));
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
        $institucion = Institucion::find($id)->update($request->all());
        return redirect('admin/institucion/'.$id);
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
