<?php

namespace App\Http\Controllers\Admin;

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
        $instituciones = Institucion::orderBy('nombre')->paginate(50);
        return view('institucion.index', compact('instituciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institucion = null;
        $paises = Pais::orderBy('pais')->get()->pluck('pais', 'id');
        $ciudad = Ciudad::orderBy('ciudad')->get()->pluck('ciudad', 'id');
        $estado = EstadoInstitucion::get()->pluck('estado', 'id');
        $tipos=TipoInstitucion::get()->pluck('tipo', 'id');
        return view('institucion.form', compact('institucion', 'ciudad', 'estado', 'paises', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $institucion = Institucion::create($request->all());
        $institucion->configuracion()->create();
        return redirect()->route('admin.institucion.index');
    }

    public function show($id, $pest = 'E')
    {
        $institucion = Institucion::find($id);
        if ($institucion->tipo_institucion_id==1) {
            return redirect()->route('institucion.show', [$id,$pest]);
        } elseif ($institucion->tipo_institucion_id==2) {
            return redirect()->route('naturales.show', [$id,$pest]);
        }
    }
}
