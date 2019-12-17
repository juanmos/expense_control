<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\CategoriaCompra;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\Cliente;
use Carbon\Carbon;
use Crypt;
use Auth;

class DocumentoFisicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$tipo)
    {
        $institucion=Institucion::find(Auth::user()->institucion_id);
        $start=now()->firstOfMonth()->toDateString();
        $end=now()->toDateString();
        if ($request->has('start_date')) {
            $start=Carbon::parse($request->get('start_date'))->toDateString();
        }
        if ($request->has('end_date')) {
            $end=Carbon::parse($request->get('end_date'))->toDateString();
        }
        if ($request->is('api/*')) {
            $dia=$institucion->documentos()
                ->where('documento',$tipo)
                ->whereBetween('fecha', [
                    Carbon::now()->subDays(7)->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $mes=$institucion->documentos()
                ->where('documento',$tipo)
                ->whereBetween('fecha', [
                    Carbon::now()->firstOfMonth()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $ano=$institucion->documentos()
                ->where('documento',$tipo)
                ->whereBetween('fecha', [
                    Carbon::now()->startOfYear()->toDateString(),
                    Carbon::now()->toDateString()
                ])->get()->sum('total');
            $documentos=$institucion->documentos()
                ->where('documento',$tipo)
                ->whereBetween('fecha', [$start,$end])
                ->with(['cliente','categoria'])
                ->orderBy('fecha', 'desc')->paginate(50);
            return Crypt::encrypt(json_encode(compact('dia', 'mes', 'ano', 'documentos')), false);
            
            // return json_encode(compact('dia', 'mes', 'ano', 'documentos'));
        }
        $documentos=$institucion->documentos()
                ->where('documento',$tipo)
                ->whereBetween('fecha', [$start,$end])
                ->with(['cliente','categoria'])
                ->orderBy('fecha', 'desc')->get();
        return Datatables::of($documentos)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$tipo)
    {
        $documento=null;
        $categorias = CategoriaCompra::get()->pluck('categoria','id');
        return view('documento.form',compact('documento','tipo','id','categorias'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$institucion_id)
    {
        $request->validate([
            'documento'=>'required|in:factura,compra,retencion',
            'foto'=>'required',
            'fecha'=>'required'
        ]);
        $data=$request->except(['foto','fecha']);
        $data['fecha']=Carbon::parse($request->get('fecha'))->toDateString();
        if($data['cliente_id']==0){
            $cliente = Cliente::where('ruc',$data['ruc'])->first();
            if($cliente==null){
                $cliente=Cliente::create([
                    'ruc'=>$data['ruc'],
                    'nombre_comercial'=>$data['cliente_nombre'],
                    'razon_social'=>$data['cliente_nombre'],
                ]);
            }
            $data['cliente_id']=$cliente->id;
        }
        $institucion =Institucion::find(Auth::user()->institucion_id);
        $documento=$institucion->documentos()->create($data);
        $documento['foto']=$request->file('foto')->store('public/documentos/'.$institucion->id.'/'.$documento->documento);
        $documento->save();
        if($request->is('api/*')){
            return response()->json(['creado'=>true]);
        }         
            
        return  ($data['documento']=='factura')?
                redirect()->route('naturales.facturacion.index',$institucion_id)->with(['mensaje'=>'Creado con exito']):
                ($data['documento']=='compra')?
                    redirect()->route('naturales.compras.index',$institucion_id)->with(['mensaje'=>'Creado con exito']):
                    redirect()->route('naturales.retenciones.index',$institucion_id)->with(['mensaje'=>'Creado con exito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Institucion $institucion, DocumentoFisico $documento)
    {
        $categorias = CategoriaCompra::get()->pluck('categoria','id');
        return view('documento.show',compact('documento','categorias'));
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
    public function update(Request $request, DocumentoFisico $documento)
    {
        
        $documento->categoria_id=$request->get('categoria_id');
        $documento->save();
        return ($request->is('api/*'))?response()->json(['actualizado'=>true]):back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DocumentoFisico $documento)
    {
        $documento->delete();
        if($request->is('api/*')){
            return response()->json(['eliminado'=>true]);
        }    
        return ($documento->documento=='factura')?
                redirect()->route('naturales.facturacion.index',$documento->institucion_id)->with(['mensaje'=>'Eliminado con exito']):
                ($documento->documento=='compra')?
                    redirect()->route('naturales.compras.index',$documento->institucion_id)->with(['mensaje'=>'Eliminado con exito']):
                    redirect()->route('naturales.retenciones.index',$documento->institucion_id)->with(['mensaje'=>'Eliminado con exito']);

    }
}
