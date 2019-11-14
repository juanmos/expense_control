<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$institucion_id=null)
    {
        $institucion_id=Auth::user()->institucion_id;
        $institucion = Institucion::find($institucion_id);
        $clientes = $institucion->clientes()->with(['cliente'])->paginate(50);
        return ($request->is('api/*'))? response()->json(compact('clientes')):view('cliente.index',compact('clientes','institucion_id'));
    }

    public function findCedula(Request $request){
        
        $cliente =  Cliente::where('ruc','like',($request->is('api/*'))?base64_decode($request->get('ruc')):$request->get('ruc').'%')->get();
        return response()->json(compact('cliente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$institucion_id)
    {
        $cliente=null;
        return view('cliente.form',compact('cliente','institucion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$institucion_id=null)
    {
        $dataCliente = $request->only(['razon_social','ruc','telefono','direccion']);
        $cliente = Cliente::create($dataCliente);
        $data=$request->only(['nombre','apellido','telefono','email']);
        if($request->has('email_facturacion') && $request->get('email_facturacion')!=null){
            $data['email_facturacion']=$request->get('email_facturacion');
        }else{
            $data['email_facturacion']=$request->get('email');
        }
        $data['cliente_id']=$cliente->id;
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $institucion->clientes()->create($data);
        return ($request->is('api/*'))?response()->json(['creado'=>true]):redirect()->route('naturales.clientes.index',Auth::user()->institucion_id);
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
