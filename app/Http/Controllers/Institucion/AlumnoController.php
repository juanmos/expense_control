<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\AlumnoExport;
use App\Imports\AlumnoImport;
use App\Models\Institucion;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
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
        $alumnos = $institucion->alumnos()->whereHas('roles',function($query){
            $query->where('name','Alumno');
        })->with('alumno')->get();
        return view('alumno.index',compact('institucion','id','alumnos'));
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
        $usuario->alumno()->create($request->only(['ano_lectivo','curso']));
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
    public function show($id,$alumno_id)
    {
        $usuario =User::find($alumno_id);    
        $transacciones = Transaccion::where('usuario_id',$alumno_id)->where('institucion_id',$id)->orderBy('fecha_hora','desc')->paginate(50);
        $hoy = Carbon::now()->toDateTimeString();
        $menos30 =Carbon::now()->subDays(30)->toDateString().' 00:00:00';
        $recargas = Transaccion::whereBetween('fecha_hora',[$menos30,$hoy])
                                ->where('institucion_id',$id)
                                ->where('usuario_id',$alumno_id)
                                ->where('tipo_transaccion_id',2)->get();
        $compras = Transaccion::whereBetween('fecha_hora',[$menos30,$hoy])
                                ->where('institucion_id',$id)
                                ->where('usuario_id',$alumno_id)
                                ->where('tipo_transaccion_id',1)->get();
        return view('alumno.show',compact('usuario','transacciones','recargas','compras','id'));
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
        $usuario->alumno()->update($request->only(['ano_lectivo','curso']));
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

    public function codificar($id,$alumno_id){
        $this->crearQR($id,$alumno_id);
        return redirect('institucion/'.$id.'/alumno/'.$alumno_id);
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
        return response()->file($user->foto);
    }
}
