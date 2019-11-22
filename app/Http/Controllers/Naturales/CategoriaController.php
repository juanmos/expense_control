<?php

namespace App\Http\Controllers\Naturales;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\CategoriaProducto;
use App\Models\CategoriaServicio;
use App\Models\Institucion;
use Carbon\Carbon;
use Crypt;
use Auth;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipo)
    {
        return view('categoria.index', compact('tipo'));
    }

    public function categoriaData(Request $request, $tipo)
    {
        if ($request->is('api/*')) {
            if ($tipo=='producto') {
                $categorias=CategoriaProducto::orderBy('categoria')->paginate(50);
            } elseif ($tipo=='servicio') {
                $categorias=CategoriaServicio::orderBy('categoria')->paginate(50);
            }
            return Crypt::encrypt(json_encode(compact('categorias')), false);
            // return response()->json(compact('categorias'));
        }
        if ($tipo=='producto') {
            $categorias=CategoriaProducto::all();
        } elseif ($tipo=='servicio') {
            $categorias=CategoriaServicio::all();
        } else {
            return 'no data';
        }
        return Datatables::of($categorias)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $tipo)
    {
        $categoria=null;
        return view('categoria.form', compact('tipo', 'categoria'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $tipo)
    {
        $data=$request->except(['foto','_token']);
        $data['institucion_id']=Auth::user()->institucion_id;
        if ($tipo=='producto') {
            $categoria=CategoriaProducto::create($data);
        } elseif ($tipo=='servicio') {
            $categoria=CategoriaServicio::create($data);
        } else {
            return redirect()->route('naturales.categoria.index', $tipo)
                        ->with(['error-mensaje'=>'No hemos podido crear la categoria proque el tipo es incorrecto']);
        }
        if ($request->has('foto') && $request->get('foto')!=null) {
            $categoria->foto=$request->file('foto')->store('public/categoria/'.Auth::user()->institucion_id);
            $categoria->save();
        }
        return ($request->is('api/*')) ?
                    response()->json(['creado'=>true]) :
                    redirect()->route('naturales.categoria.index', $tipo)
                            ->with(['success'=>'La categoria ha sido creada']);
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
    public function edit($tipo, $id)
    {
        if ($tipo=='producto') {
            $categoria=CategoriaProducto::find($id);
        } elseif ($tipo=='servicio') {
            $categoria=CategoriaServicio::find($id);
        } else {
            return redirect()->route('naturales.categoria.index', $tipo)
                            ->with([
                                'error-mensaje'=>'No hemos podido crear la categoria proque el tipo es incorrecto'
                                ]);
        }
        return view('categoria.form', compact('tipo', 'categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tipo, $id)
    {
        $data=$request->except(['foto','_token']);
        $data['institucion_id']=Auth::user()->institucion_id;
        if ($tipo=='producto') {
            $categoria=CategoriaProducto::find($id);
        } elseif ($tipo=='servicio') {
            $categoria=CategoriaServicio::find($id);
        } else {
            return redirect()->route('naturales.categoria.index', $tipo)
                        ->with(['error-mensaje'=>'No hemos podido crear la categoria proque el tipo es incorrecto']);
        }
        $categoria->update($data);
        if ($request->has('foto') && $request->get('foto')!=null) {
            $categoria->foto=$request->file('foto')->store('public/categoria/'.Auth::user()->institucion_id);
            $categoria->save();
        }
        return ($request->is('api/*')) ?
                    response()->json(['creado'=>true]) :
                    redirect()->route('naturales.categoria.index', $tipo)
                            ->with(['success'=>'La categoria ha sido creada']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $tipo, $id)
    {
        if ($tipo=='producto') {
            $categoria=CategoriaProducto::find($id);
        } elseif ($tipo=='servicio') {
            $categoria=CategoriaServicio::find($id);
        }
        $categoria->delete();
        return ($request->is('api/*')) ?
                        response()->json(['eliminado'=>true]) :
                        redirect()->route('naturales.categoria.index', $tipo)
                                ->with(['success'=>'La categoria ha sido eliminada']);
    }
}
