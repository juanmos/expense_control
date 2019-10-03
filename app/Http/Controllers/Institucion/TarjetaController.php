<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers;
use App\Models\TipoTarjeta;
use App\Models\Tarjeta;
use App\Models\User;
use Carbon\Carbon;
use Auth;
class TarjetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $tarjeta=null;
        $tipos=TipoTarjeta::get()->pluck('tipo_tarjeta','id');
        return view('tarjeta.form',compact('tarjeta','tipos','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $user = User::find($id);
        $tarjeta=$user->tarjetas()->create([
            'tipo_tarjeta_id'=>$request->get('tipo_tarjeta_id'),
            'cupo_mensual'=>$request->get('cupo_mensual'),
            'fecha_solicitud'=>Carbon::now()->toDateTimeString(),
            'fecha_vencimiento'=>Carbon::now()->addDays(270)->toDateTimeString(),
            'usuario_crea_id'=>Auth::user()->id
        ]);
        $tarjeta->codigo=Helpers::creaQR($user->id,$tarjeta->id);
        $tarjeta->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
