<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Helpers;
use App\Exports\AlumnoExport;
use App\Imports\AlumnoImport;
use App\Models\DatosFacturacion;
use App\Models\TipoRefrigerio;
use App\Models\FormaPago;
use App\Models\TipoTransaccion;
use App\Models\TipoTarjeta;
use App\Models\Institucion;
use App\Models\Transaccion;
use App\Models\Tarjeta;
use App\Models\User;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Storage;
use Artisan;
use Auth;
use Crypt;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $institucion = Institucion::find($id);
        
        return view('alumno.index',compact('institucion','id'));
    }

    public function alumnosData(Request $request,$id)
    {
        $institucion = Institucion::find($id);
        
        if($request->is('api/*')) {
            $alumnos = $institucion->alumnos()->whereHas('roles',function($query){
                $query->where('name','Alumno');
            })->with('alumno')->orderBy('apellido')->paginate(50);
            return response()->json(compact('alumnos'));
        }
        $alumnos = $institucion->alumnos()->whereHas('roles',function($query){
            $query->where('name','Alumno');
        })->with('alumno')->orderBy('apellido')->get();
        return Datatables::of($alumnos)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $usuario =null;
        return view('alumno.form',compact('usuario','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('email',$request->get('email'))->first();
        if($user!=null){
            return back()->withErrors(['email'=>'Email ya usado'])->withInput($request->input());
        }
        $data=$request->except(['ano_lectivo','curso']);
        $data['password']=bcrypt(random_bytes(10));
        $usuario=User::create($data);
        $usuario->alumno()->create($request->only(['ano_lectivo','curso','profesor']));
        $usuario->assignRole('Alumno');
        if($request->has('foto')){
            $usuario->foto=$request->file('foto')->store('public/alumnos');
            $usuario->save();
        }
        $this->crearQR($request->get('institucion_id'),$usuario->id);
        return redirect('institucion/'.$request->get('institucion_id').'/alumno/'.$usuario->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id,$alumno_id)
    {
        $usuario =User::find($alumno_id);   
        $institucion = Institucion::find($id);
        $transacciones = $institucion->transacciones()->where('usuario_id',$alumno_id)->orderBy('fecha_hora','desc')->paginate(50);
        $hoy = Carbon::now()->toDateTimeString();
        $menos30 =Carbon::now()->subDays(30)->toDateString().' 00:00:00';
        $recargas =$institucion->transacciones()->whereBetween('fecha_hora',[$menos30,$hoy])
                                ->where('usuario_id',$alumno_id)
                                ->whereIn('tipo_transaccion_id',[2,3])->get();
        $compras =$institucion->transacciones()->whereBetween('fecha_hora',[$menos30,$hoy])
                                ->where('usuario_id',$alumno_id)
                                ->whereIn('tipo_transaccion_id',[1,4,5])->get();
        $tipo_tarjetas=TipoTarjeta::get()->pluck('tipo_tarjeta','id');    
        $tipos_refrigerio=TipoRefrigerio::orderBy('tipo')->get()->pluck('tipo','id');      
        $formas_pago = FormaPago::where('habilitado',1)->orderBy('forma_pago')->get()->pluck('forma_pago','id');   
        $tipo_pago = TipoTransaccion::whereIn('id',[5])->orderBy('tipo')->get()->pluck('tipo','id');    
        return view('alumno.show',compact('usuario','transacciones','recargas','compras','id','tipo_tarjetas','tipos_refrigerio','formas_pago','tipo_pago'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$alumno_id)
    {
        $usuario =User::find($alumno_id);
        return view('alumno.form',compact('usuario','id'));
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
        $usuario =User::find($id);
        $data=$request->except(['ano_lectivo','curso']);
        $usuario->update($data);
        $usuario->alumno()->update($request->only(['ano_lectivo','curso','profesor']));
        if($request->has('foto')){
            $usuario->foto=$request->file('foto')->store('public/alumnos');
            $usuario->save();
        }
        $this->crearQR($request->get('institucion_id'),$usuario->id);
        return redirect('institucion/'.$request->get('institucion_id').'/alumno/'.$id);
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

    public function cargar($id){
        return view('alumno.carga',compact('id'));
    }

    public function import(Request $request) 
    {
        Excel::import(new AlumnoImport($request->except(['archivo'])), $request->file('archivo'));
        Artisan::call('alumno:qr');
        return redirect('institucion/'.$request->get('id').'/alumnos')->with('mensaje', 'Clientes cargados con exito!');
    }

    public function exportar($id){
        return Excel::download(new AlumnoExport($id),'Alumnos.xlsx');
    }

    public function codificar($id,$tid){
        $tarjeta = Tarjeta::find($tid);
        $tarjeta->codigo=Helpers::creaQR($id,$tid);
        $tarjeta->save();
    }

    private function crearQR($id,$alumno_id){
        $usuario =User::find($alumno_id);
        $cryptId=base64_encode($usuario->id);
        $usuario->codigo=Crypt::encryptString($usuario->cedula.'|'.$usuario->full_name.'|'.$usuario->alumno->ano_lectivo.'|'.$usuario->alumno->curso.'|'. $cryptId);
        $usuario->save();
        return true;
    }

    public function imagen($id){
        $user = User::find(base64_decode($id));
        return Storage::download($user->foto);//response()->file($user->foto);
    }

    public function transacciones(Request $request,$id){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $transacciones = $institucion->transacciones()->where('usuario_id',base64_decode($id))->orderBy('fecha_hora','desc')->paginate(50);
        return Crypt::encrypt(json_encode(compact('transacciones')),false);
        // if($request->is('api/*')) return response()->json(compact('transacciones'));
    }

    public function tarjetas($id){
        $tarjetas = Tarjeta::where('usuario_id',base64_decode($id))->with(['tipo_tarjeta'])->paginate(50);
        // return response()->json(compact('tarjetas'));
        return Crypt::encrypt(json_encode(compact('tarjetas')),false);
    }

    public function datos_facturacion($id){
        $datos = DatosFacturacion::find($id);
        return $datos;
    }
    
}
