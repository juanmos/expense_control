<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Transaccion;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\EstadoInstitucion;
use App\Models\Configuracion;
use App\Models\TipoInstitucion;
use Carbon\Carbon;
use Crypt;
use Hash;
use Auth;

class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('institucion.show',Auth::user()->institucion_id);
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
        $tipos=TipoInstitucion::get()->pluck('tipo','id');
        return view('institucion.form',compact('institucion','ciudad','estado','paises','tipos'));
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
        return redirect()->route('institucion.index',$id);
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

    public function configuracion(){
        $institucion =Institucion::find(Auth::user()->institucion_id);
        $configuracion = Configuracion::where('institucion_id',Auth::user()->institucion_id)->first();
        if($configuracion==null){
            $configuracion = Configuracion::create(['institucion_id'=>Auth::user()->institucion_id]);
        }
        
        return view('institucion.configuracion',compact('configuracion','institucion'));
    }

    public function configuracionUpdate(Request $request,$id){
        $configuracion=Configuracion::find($id);
        $data=$request->except(['firma','clave','clave_sri','_method',"_token"]);
        if($request->has('firma') ){
            $data['firma']=$request->file('firma')->store('public/firmas/'.$id);
        }else{
            $data['firma']=$configuracion->configuraciones['firma'];
        }
        if($request->has('clave') && $request->get('clave')!=null){
            $data['clave']=Crypt::encrypt($request->get('clave'));
        }else{
            $data['clave']=$configuracion->configuraciones['clave'];
        }
        if($request->has('clave_sri') && $request->get('clave_sri')!=null){
            $data['clave_sri']=Crypt::encrypt($request->get('clave_sri'));
        }else{
            $data['clave_sri']=$configuracion->configuraciones['clave_sri'];
        }
        $configuracion->configuraciones=$data;
        $configuracion->save();
        return back()->with('mensaje','Configuraciones guardadas con exito');
    }
}
