<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\Transaccion;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\EstadoInstitucion;
use App\Models\Configuracion;
use App\Models\TipoInstitucion;
use Carbon\Carbon;
use Crypt;
use Hash;
use Auth;

class InstitucionController extends Controller
{
    public function index()
    {
        return redirect()->route('institucion.show', Auth::user()->institucion_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $pest = 'E')
    {
        if ($pest==null) {
            $pest='E';
        }
        $institucion = Institucion::find($id);
        $alumnos = $institucion->alumnos()->whereHas('roles', function ($query) {
            $query->where('name', 'Alumno');
        })->with('roles')->get();
        $usuarios = $institucion->alumnos()->whereHas('roles', function ($query) {
            $query->whereIn('name', ['PersonaNatural']);
        })->with('roles')->get();
        $compras=[];
        $compras['dia']=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras['mes']=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras['ano']=$institucion->compras()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $compras['total']=$institucion->compras()
            ->get()->count();
        $ventas=[];
        $ventas['dia']=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $ventas['mes']=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->firstOfMonth()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $ventas['ano']=$institucion->facturas()->whereBetween('fecha', [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->get()->sum('total');
        $ventas['total']=$institucion->facturas()
            ->get()->count();

        return view('naturales.show', compact(
            'institucion',
            'alumnos',
            'id',
            
            'compras',
            'ventas',
            'pest',
            'usuarios'
        ));
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

    public function configuracion()
    {
        $institucion =Institucion::find(Auth::user()->institucion_id);
        $configuracion = Configuracion::where('institucion_id', Auth::user()->institucion_id)->first();
        if ($configuracion==null) {
            $configuracion = Configuracion::create(['institucion_id'=>Auth::user()->institucion_id]);
        }
        
        return view('institucion.configuracion', compact('configuracion', 'institucion'));
    }
}
