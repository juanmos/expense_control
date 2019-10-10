<?php

namespace App\Http\Controllers\Institucion;

use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Refrigerio;
use App\Models\TipoRefrigerio;
use App\Models\User;
use Carbon\Carbon;
use Auth;

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
        return view('alumno.index',compact('institucion','id'));
    }

    public function refrigeriosData()
    {
        
        $id=Auth::user()->institucion_id;
        $institucion = Institucion::find($id);
        $alumnos = $institucion->alumnos()->has('refrigerio')->whereHas('roles',function($query){
            $query->where('name','Alumno');
        })->with('alumno','refrigerio.tipo_refrigerio')->get();
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
        $tipos=TipoRefrigerio::orderBy('tipo')->get()->pluck('tipo','id');
        return view('refrigerio.form',compact('usuario','tipos','id','refrigerio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = User::find($request->get('usuario_id'));
        $tipos=TipoRefrigerio::find($request->get('tipo_refrigerio_id'));
        $dias=array_values($request->get('dias'));
        $costo=$tipos->costo*count($request->get('dias'));
        
        $usuario->refrigerio()->create([
            'tipo_refrigerio_id'=>$request->get('tipo_refrigerio_id'),
            'dias'=>$dias,
            'institucion_id'=>Auth::user()->institucion_id,
            'fecha_inicio'=>Carbon::parse($request->get('fecha_inicio'))->toDateString(),
            'fecha_fin'=>Carbon::parse($request->get('fecha_fin'))->toDateString(),
            'costo'=>$costo
        ]);
        return redirect()->route('institucion.alumno.show',[Auth::user()->institucion_id,$usuario->id]);
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
        $refrigerio = Refrigerio::find($id);
        $tipos=TipoRefrigerio::find($request->get('tipo_refrigerio_id'));
        $dias=array_values($request->get('dias'));
        
        $costo=$tipos->costo*count($request->get('dias'));
        $refrigerio->update([
            'tipo_refrigerio_id'=>$request->get('tipo_refrigerio_id'),
            'dias'=>$dias,
            'fecha_inicio'=>Carbon::parse($request->get('fecha_inicio'))->toDateString(),
            'fecha_fin'=>Carbon::parse($request->get('fecha_fin'))->toDateString(),
            'costo'=>$costo
        ]);

        return redirect()->route('institucion.alumno.show',[Auth::user()->institucion_id,$refrigerio->userable_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $refrigerio = Refrigerio::find($id);
        $refrigerio->delete();
        return back();
    }
}
