<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
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
        $request->validate([
            'documento'=>'required|in:factura,compra,retencion',
            'foto'=>'required',
            'fecha'=>'required'
        ]);
        $data=$request->except(['foto','fecha']);
        $data['fecha']=Carbon::parse($request->get('fecha'))->toDateString();
        $institucion =Institucion::find(Auth::user()->institucion_id);
        $documento=$institucion->documentos()->create($data);
        $documento['foto']=$request->file('foto')->store('public/documentos/'.$institucion->id.'/'.$documento->documento);
        $documento->save();
        return ($request->is('api/*'))?response()->json(['creado'=>true]):back();
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