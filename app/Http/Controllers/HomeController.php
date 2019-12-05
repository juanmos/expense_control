<?php

namespace App\Http\Controllers;

use App\Notifications\UsuarioRegistradoNotification;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user= User::find(Auth::user()->id);
        if ($user->hasRole('SuperAdministrador')) {
            return redirect()->route('admin.institucion.index');
            //return view('admin.panel');
        } elseif ($user->hasRole('Institucion')) {
            return redirect()->route('institucion.show', $user->institucion_id);
        } elseif ($user->hasRole('PersonaNatural')) {
            return redirect()->route('naturales.show', $user->institucion_id);
        } 
        return redirect()->route('register.institucion');
    }

    public function register()
    {
        $institucion=null;
        $user=Auth::user();
        return view('institucion.register',compact('institucion','user'));
    }

    public function registerInstitucion(Request $request){
        $request->validate([
            'nombre'=>'required',
            'direccion'=>'required',
            'ruc'=>'required|numeric'
        ]);
        $data=$request->all();
        $data['tipo_institucion_id']=2;
        $data['estado_id']=3;
        $institucion = Institucion::create($data);
        $user=Auth::user();
        $user->institucion_id=$institucion->id;
        $user->save();
        $user->syncRoles('PersonaNatural');
        $configuraciones=[
            'establecimiento'=>'001',
            'punto'=>'500',
            'secuencia'=>'1',
            'ambiente_facturacion'=>1,
            'direccion_facturacion'=>$request->get('direccion'),
            'contabilidad'=>'NO',
            'email_facturacion'=>$user->email,
            'ruc'=>$request->get('ruc'),
            'razon_social'=>$request->get('nombre'),
            'nombre_comercial'=>$request->get('siglas')!=null ? $request->get('siglas'):$request->get('nombre') 
        ];
        $institucion->configuracion()->create([
            'configuraciones'=>$configuraciones
        ]);
        $user->notify(new UsuarioRegistradoNotification($institucion));
        return ($request->is('api/*'))? response()->json(['creado'=>true]):redirect()->route('home');
    }
}
