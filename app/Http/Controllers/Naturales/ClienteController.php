<?php

namespace App\Http\Controllers\Naturales;


use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use Crypt;
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
        return ($request->is('api/*'))?  Crypt::encrypt(json_encode(compact('clientes')),false) :view('cliente.index',compact('clientes','institucion_id'));
    }

    public function clientesData(Request $request,$institucion_id=null){
        $institucion_id=Auth::user()->institucion_id;
        $institucion = Institucion::find($institucion_id);
        $clientes = $institucion->clientes()->with(['cliente'])->get();
        return Datatables::of($clientes)->make(true);
    }

    public function findCedula(Request $request){
        $clientes =  Cliente::where('ruc','like',($request->is('api/*'))?base64_decode($request->get('ruc')):$request->get('ruc').'%')->get();
        return ($request->is('api/*'))?  Crypt::encrypt(json_encode(compact('clientes')),false) : response()->json(compact('clientes'));
    }

    public function buscar(Request $request){
        $texto=($request->is('api/*'))?base64_decode($request->get('texto')):$request->get('texto');
        $clientes =  ClienteInstitucion::where('institucion_id',Auth::user()->institucion_id)->whereHas('cliente',function($query) use($texto){
            $query->where(function($q) use ($texto){
                $q->orWhere('ruc','like',$texto.'%');
                $q->orWhere('razon_social','like','%'.$texto.'%');
            });
        })->with('cliente')->paginate(50);
        // return $clientes;
        return ($request->is('api/*'))?  Crypt::encrypt(json_encode(compact('clientes')),false) : response()->json(compact('clientes'));
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
        $request->validate([
            'razon_social'=>'required',
            'ruc'=>'required',
            'telefono'=>'required',
            'direccion'=>'required',
            'nombre'=>'required',
            'apellido'=>'required',
        ]);
        $cliente=Cliente::where('ruc',$request->get('ruc'));
        if($cliente==null){
            $dataCliente = $request->only(['razon_social','ruc','telefono','direccion']);
            $$dataCliente['usuario_crea_id']=Auth::user()->id;
            $cliente = Cliente::create($dataCliente);
        }       
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
    public function show(Request $request,$institucion_id,$id)
    {
        $cliente = ClienteInstitucion::find($id);
        return ($request->is('api/*'))?response()->json(compact('cliente')):view('cliente.show',compact('cliente','institucion_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$institucion_id,$id)
    {
        $cliente=ClienteInstitucion::find($id);
        return view('cliente.form',compact('cliente','institucion_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$institucion_id, $id=null)
    {
        $cliente = ClienteInstitucion::find(($request->is('api/*'))? base64_decode($institucion_id) :$id);
        $data=$request->only(['nombre','apellido','telefono','email']);
        if($request->has('email_facturacion') && $request->get('email_facturacion')!=null){
            $data['email_facturacion']=$request->get('email_facturacion');
        }else{
            $data['email_facturacion']=$request->get('email');
        }
        $cliente->update($data);
        $cliente = ClienteInstitucion::where('id',$cliente->id)->with('cliente')->first();
        return ($request->is('api/*'))?  Crypt::encrypt(json_encode(compact('cliente')),false) :redirect()->route('naturales.clientes.show',[$institucion_id, $id]);
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
