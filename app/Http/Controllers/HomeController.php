<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user= User::find(Auth::user()->id);
        if($user->hasRole('SuperAdministrador')){
            return redirect('admin/institucion');
            //return view('admin.panel');
        }else if($user->hasRole('Administrador') || $user->hasRole('JefeVentas')){
            if($user->primer_login){
                return redirect('/e/usuario/'.$user->id.'/edit')->with('info','Debes cambiar tu contraseña e ingresar tu foto');
            }
            $empresa = Empresa::find($user->empresa_id);
            $clientes = Cliente::where('empresa_id',$user->empresa_id)->get();
            $visitas = Visita::whereHas('cliente',function($query) use($clientes){
                $query->whereIn('cliente_id',$clientes->pluck('id'));
            })->get()->count();
            $visitasTerminadas = Visita::whereHas('cliente',function($query) use($clientes){
                $query->whereIn('cliente_id',$clientes->pluck('id'));
            })->where('estado_visita_id',5)->get()->count();
            if(Auth::user()->hasRole('Administrador')){
                $usuarios=$empresa->usuarios;
            }elseif(Auth::user()->hasRole('JefeVentas')){
                $usuarios=User::where('empresa_id',$user->empresa_id)->where('user_id',$user->id)->get();
                $usuarios->push($user);
            }else{
                $usuarios=User::where('id',$user->id)->get();
            }
            
            return view('empresa.show',compact('empresa','visitas','visitasTerminadas','clientes','usuarios'));
            
        }else if($user->hasRole('Vendedor')){
            return redirect('e/visitas/vendedor/'.$user->id);
        }
        dd('No rol');
    }

    public function panel(){
        
    }
}
