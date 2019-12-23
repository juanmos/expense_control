<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\ClienteInstitucion;
use App\Models\Institucion;
use App\Models\Cliente;
use Carbon\Carbon;
use Crypt;
use Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $institucion_id = null)
    {
        $institucion_id=Auth::user()->institucion_id;
        $institucion = Institucion::find($institucion_id);
        return ($request->is('api/*'))?
                    Crypt::encrypt(json_encode(compact('clientes')), false) :
                    view('cliente.index', compact( 'institucion_id'));
    }

    public function clientesData(Request $request, $institucion_id = null)
    {
        $institucion_id=Auth::user()->institucion_id;
        $institucion = Institucion::find($institucion_id);
        if($request->is('api/*')){
            $clientesInstitucion = $institucion->clientes()->orderBy(function($query){
                $query->select('nombre_comercial')
                    ->from('clientes')
                    ->whereColumn('clientes.id','cliente_institucions.cliente_id')
                    ->orderBy('nombre_comercial');
            })->paginate(50);
            $clientesLista = Cliente::whereIn('id',$clientesInstitucion->pluck('cliente_id'))
                ->with(['clienteInstitucion'=> function ($query) use ($institucion_id) {
                    $query->where('institucion_id', $institucion_id);
                }])->orderBy('nombre_comercial')->get();
            $clientes=$clientesInstitucion->toArray();
            $clientes['data']=$clientesLista;
            return  Crypt::encrypt(json_encode(compact('clientes')), false);
        }
         $clientes = $institucion->clientes()->with(['cliente'])->get()->sortBy(function ($useritem, $key) {
                return $useritem->cliente->razon_social;
            });
        return Datatables::of($clientes)->make(true);
    }

    public function findCedula(Request $request)
    {
        if($request->is('api/*')){
            $request->validate([
                'ruc'=>'required'
            ]);
            $clientes =  Cliente::where(
                'ruc',
                'like', 
                base64_decode($request->get('ruc')).'%'
            )->orderBy('nombre_comercial')->get();
            return Crypt::encrypt(json_encode(compact('clientes')), false) ;
        }else{
            $clientes =  Cliente::where('ruc','like', $request->query('q').'%')->orderBy('nombre_comercial')
                            ->select('nombre_comercial as text','id as value','ruc')                
                            ->get();
        }
        
        return response()->json($clientes);
    }

    public function findById(Request $request, $insitucion_id, $id)
    {
        $clientes =  Cliente::where('id', $id)->with(['clienteInstitucion'=>function ($query) use ($id) {
            $query->where('institucion_id', Auth::user()->institucion_id);
            $query->where('cliente_id', $id);
        }])->first();
        return ($request->is('api/*'))?
                    Crypt::encrypt(json_encode(compact('clientes')), false):
                    response()->json(compact('clientes'));
    }

    public function buscar(Request $request)
    {
        $texto=($request->is('api/*'))?base64_decode($request->get('texto')):$request->get('texto');
        if(($request->is('api/*'))){
            $clientes = Cliente::where(function ($q) use ($texto) {
                                $q->orWhere('ruc', 'like', $texto.'%');
                                $q->orWhere('nombre_comercial', 'like', '%'.$texto.'%');
                            })->with('clienteInstitucion')->paginate(50);
            return Crypt::encrypt(json_encode(compact('clientes')), false);
        }else{
            $clientes = Cliente::with('clienteInstitucion')->get();
            return Datatables::of($clientes)->make(true);
        }
                            
        
        // $clientes =  ClienteInstitucion::where('institucion_id', Auth::user()->institucion_id)
        //                 ->whereHas('cliente', function ($query) use ($texto) {
        //                     $query->where(function ($q) use ($texto) {
        //                         $q->orWhere('ruc', 'like', $texto.'%');
        //                         $q->orWhere('razon_social', 'like', '%'.$texto.'%');
        //                     });
        //                 })->with('cliente')->paginate(50);
        // return $clientes;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $institucion_id)
    {
        $cliente=null;
        return view('cliente.form', compact('cliente', 'institucion_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $institucion_id = null)
    {
        $request->validate([
            'razon_social'=>'required',
            'ruc'=>'required',
            'telefono'=>'required',
            'direccion'=>'required',
            'nombre'=>'required',
            'apellido'=>'required',
        ]);
        $cliente=Cliente::where('ruc', $request->get('ruc'));
        if ($cliente==null) {
            $dataCliente = $request->only(['razon_social','ruc','telefono','direccion']);
            $$dataCliente['usuario_crea_id']=Auth::user()->id;
            $cliente = Cliente::create($dataCliente);
        }
        $data=$request->only(['nombre','apellido','telefono','email']);
        if ($request->has('email_facturacion') && $request->get('email_facturacion')!=null) {
            $data['email_facturacion']=$request->get('email_facturacion');
        } else {
            $data['email_facturacion']=$request->get('email');
        }
        $data['cliente_id']=$cliente->id;
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $institucion->clientes()->create($data);
        return ($request->is('api/*'))?
                        response()->json(['creado'=>true]):
                        redirect()->route('naturales.clientes.index', Auth::user()->institucion_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $institucion_id, $id)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $cliente = ClienteInstitucion::find($id);
        if(!$request->is('api/*')){
            $compras=[];
            $compras['dia']=$institucion->compras()->whereBetween('fecha', [
                    Carbon::now()->subDays(7)->toDateString(),
                    Carbon::now()->toDateString()
                ])->where('cliente_id', $id)
                ->get()->sum('total');
            $compras['mes']=$institucion->compras()->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->where('cliente_id', $id)
                ->get()->sum('total');
            $compras['ano']=$institucion->compras()->whereBetween('fecha', [
                    Carbon::now()->startOfYear()->toDateString(),
                    Carbon::now()->toDateString()
                ])->where('cliente_id', $id)
                ->get()->sum('total');
            $compras['total']=$institucion->compras()->where('cliente_id', $id)
                ->get()->count();
            $ventas=[];
            $ventas['dia']=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->subDays(7)->toDateString(),
                    Carbon::now()->toDateString()
                ])->where('cliente_id', $id)
                ->get()->sum('total');
            $ventas['mes']=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->where('cliente_id', $id)
                ->get()->sum('total');
            $ventas['ano']=$institucion->facturas()->whereBetween('fecha', [
                    Carbon::now()->startOfYear()->toDateString(),
                    Carbon::now()->toDateString()
                ])->where('cliente_id', $id)
                ->get()->sum('total');
            $ventas['total']=$institucion->facturas()->where('cliente_id', $id)
                ->get()->count();
        }
        return ($request->is('api/*'))?
                            response()->json(compact('cliente')):
                            view('cliente.show', compact('cliente', 'institucion_id','compras','ventas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $institucion_id, $id)
    {
        $cliente=ClienteInstitucion::find($id);
        return view('cliente.form', compact('cliente', 'institucion_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $institucion_id, $id = null)
    {
        $cliente = ClienteInstitucion::find(($request->is('api/*'))? base64_decode($institucion_id) :$id);
        $data=$request->only(['nombre','apellido','telefono','email']);
        if ($request->has('email_facturacion') && $request->get('email_facturacion')!=null) {
            $data['email_facturacion']=$request->get('email_facturacion');
        } else {
            $data['email_facturacion']=$request->get('email');
        }
        $cliente->update($data);
        $cliente = ClienteInstitucion::where('id', $cliente->id)->with('cliente')->first();

        $clienteGeneral = Cliente::find($cliente->cliente_id);
        if($clienteGeneral!=null && $clienteGeneral->direccion==null){
            $clienteGeneral->direccion=$request->get('direccion');
            $clienteGeneral->save();
        }
        if($clienteGeneral!=null && $clienteGeneral->nombre_comercial==null){
            $clienteGeneral->nombre_comercial=$request->get('nombre_comercial');
            $clienteGeneral->save();
        }
        if($clienteGeneral!=null && $clienteGeneral->razon_social==null){
            $clienteGeneral->razon_social=$request->get('razon_social');
            $clienteGeneral->save();
        }
        if($clienteGeneral!=null && $clienteGeneral->telefono==null){
            $clienteGeneral->telefono=$request->get('telefono');
            $clienteGeneral->save();
        }
        return ($request->is('api/*'))?
                        Crypt::encrypt(json_encode(compact('cliente')), false) :
                        redirect()->route('naturales.clientes.show', [$institucion_id, $id]);
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
