<?php

namespace App\Http\Controllers\Institucion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\TipoRefrigerio;
use App\Models\MenuRefrigerio;
use Carbon\Carbon;
use Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($institucion_id)
    {
        $tipos = TipoRefrigerio::where('institucion_id',$institucion_id)->get();
        return view('menus.index',compact('tipos','institucion_id'));
    }

    public function menus(Request $request,$institucion_id,$tipo_refrigerio){
        $menus = MenuRefrigerio::where('institucion_id',$institucion_id)
                        ->where('tipo_refrigerio_id',$tipo_refrigerio)
                        ->whereBetween('fecha',[$request->get('start'),$request->get('end')])
                        ->get();
        foreach($menus as $menu){
            $menu->start=$menu->fecha;
            $menu->end=$menu->fecha;
            $menu->title=$menu->titulo;
        }
        return $menus;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($institucion_id)
    {
        $tipos = TipoRefrigerio::where('institucion_id',$institucion_id)->get()->pluck('tipo','id');
        $menu = null;
        return view('menus.form',compact('tipos','menu','institucion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$institucion_id)
    {
        $institucion = Institucion::find($institucion_id);
        $data=$request->except(['foto']);
        $data['fecha']=Carbon::parse($data['fecha'])->toDateString();
        $menu= $institucion->menus()->create($data);
        if($request->has('foto')){
            $menu->foto=$request->file('foto')->store('public/menus/'.$institucion_id);
            $menu->save();
        }
        return redirect()->route('institucion.menus.index',$institucion_id);
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
    public function edit($institucion_id,$id)
    {
        $tipos = TipoRefrigerio::where('institucion_id',$institucion_id)->get()->pluck('tipo','id');
        $menu = MenuRefrigerio::find($id);;
        return view('menus.form',compact('tipos','menu','institucion_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$institucion_id, $id)
    {
        $data=$request->except(['foto']);
        $data['fecha']=Carbon::parse($data['fecha'])->toDateString();
        $menu= MenuRefrigerio::find($id);
        $menu->update($data);
        if($request->has('foto')){
            $menu->foto=$request->file('foto')->store('public/menus/'.$institucion_id);
            $menu->save();
        }
        return redirect()->route('institucion.menus.index',$institucion_id);
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
