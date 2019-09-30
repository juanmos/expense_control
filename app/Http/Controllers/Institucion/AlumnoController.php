<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\AlumnoImport;

use App\Models\Institucion;
use App\Models\User;
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
    public function create()
    {
        //
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
    public function show($id)
    {
        $usuario =User::find($id);    
        return view('alumno.show',compact('usuario'));
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

    public function cargar($id){
        return view('alumno.carga',compact('id'));
    }

    public function import(Request $request) 
    {
        
        Excel::import(new AlumnoImport($request->except(['archivo'])), $request->file('archivo'));
        Artisan::call('alumno:qr');
        return redirect('institucion/'.$request->get('id').'/alumnos')->with('mensaje', 'Clientes cargados con exito!');
    }

    public function codificar($id){
        $usuario =User::find($id);
        $cryptId=base64_encode($usuario->id);
        $usuario->codigo=Crypt::encryptString($usuario->cedula.'|'.$usuario->full_name.'|'.$usuario->alumno->ano_lectivo.'|'.$usuario->alumno->curso.'|'. $cryptId);
        $usuario->save();
        return view('alumno.show',compact('usuario'));
    }

    public function imagen($id){
        $user = User::find(base64_decode($id));
        return response()->file($user->foto);
    }
}
