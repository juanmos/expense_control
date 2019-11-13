<?php

namespace App\Http\Controllers\Naturales;


use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\Institucion;
use App\Models\User;
use Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $usuarios = $institucion->alumnos()->whereHas('roles',function($query){
            $query->whereIn('name',['PersonaNatural']);
        })->with('roles')->paginate(50);
        return view('usuario.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $tipo='naturales';
        $usuario=null;
        $roles = Role::where('name','like','PersonaNatural%')->orderBy('name')->get()->pluck('name','name');
        return view('usuario.form',compact('usuario','id','roles','tipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['foto','password']);
        $email = User::where('email',$data['email'])->withTrashed()->get();        
        if($email->count()>0){
            return back()->withErrors(['email'=>'Email ya existe'])->withInput();
        }
        if($request->has('password')){
            if(strlen($request->get('password'))>5)
                $data['password']=bcrypt($request->get('password'));
            else {
                return back()->withErrors(['password'=>'Contraseña demasiado corta, minimo 6 caracteres'])->withInput();
            }
        }        
        $usuario = User::create($data);
        if($request->has('foto')){
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        $usuario->syncRoles($request->get('role'));
        return redirect()->route('naturales.show',[$request->get('institucion_id'),'U']);
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
    public function edit($id,$user_id)
    {
        $tipo='naturales';
        $usuario=User::find($user_id);
        $roles = Role::where('name','like','PersonaNatural%')->orderBy('name')->get()->pluck('name','name');
        return view('usuario.form',compact('usuario','id','roles','tipo'));
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
        $usuario = User::find($id);
        $usuario->update($request->except(['foto','password']));
        if($request->has('foto')){
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        if($request->has('password') && $request->get('password')!=null){
            $usuario->password=bcrypt($request->get('password'));
            $usuario->save();
        }
        if($request->has('role')) $usuario->syncRoles($request->get('role'));
        return redirect()->route('naturales.show',[$request->get('institucion_id'),'U']);
        
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

