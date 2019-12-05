<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoRefrigerio;
use App\Models\Institucion;
use Auth;

class TipoRefrigerioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = TipoRefrigerio::where('institucion_id', Auth::user()->institucion_id)->get();
        return view('tipo_refrigerio.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo=null;
        return view('tipo_refrigerio.form', compact('tipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        Institucion::find(Auth::user()->institucion_id)->tipo_refrigerio()->create($data);
        return redirect()->route('institucion.refrigerios.tipos.index');
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
        $tipo=TipoRefrigerio::find($id);
        return view('tipo_refrigerio.form', compact('tipo'));
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
        $tipo=TipoRefrigerio::find($id);
        $tipo->update($request->all());
        return redirect()->route('institucion.refrigerios.tipos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo=TipoRefrigerio::find($id);
        $tipo->delete();
        return redirect()->route('institucion.refrigerios.tipos.index');
    }
}
