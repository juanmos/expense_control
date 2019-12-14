<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayuda;

class AyudaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ayudas = Ayuda::orderBy('titulo')->paginate(50);
        return view('ayuda.index',compact('ayudas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ayuda=new Ayuda;
        return view('ayuda.form',compact('ayuda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'titulo'=>'required'
        ]);
        $ayuda = Ayuda::create($data);
        return redirect()->route('ayuda.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ayuda $ayuda)
    {
        return view('ayuda.form',compact('ayuda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Ayuda $ayuda)
    {
        $data=$request->validate([
            'titulo'=>'required'
        ]);
        $ayuda->update($data);
        return redirect()->route('ayuda.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ayuda $ayuda)
    {
        $ayuda->delete();
        return back()->with(['mensaje'=>'La ayuda ha sido eliminada']);
    }
}
