<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuthExceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoriaCompra;
use App\Models\TipoRefrigerio;
use App\Models\TipoTarjeta;
use App\Models\User;
use App\Models\Ciudad;
use Carbon\Carbon;
use JWTAuth;
use DateTime;
use Image;
use Input;
use Mail;
use Event;
use Config;
use Validator;
use Crypt;

class APIAuthController extends Controller
{
    public function __construct()
    {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['login','authenticate','nuevoUsuario','passForgot']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 401);
        }
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'error' => 'No hemos encontrado tus credenciales de usuario. Por favor contacte al administrador.'
                ], 404);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'success' => false,
                'error' => 'Error al iniciar sesión, por favor intente nuevamente.'
            ], 500);
        }
        // all good so return the token
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer'
        ]);
        //return response()->json(['success' => true, 'data'=> [ 'token' => $token ]], 200);
    }
   /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = User::where('id', auth('api')->user()->id)->with(['institucion.configuracion'])->first();
            $roles = $user->getRoleNames();
            $ciudades = Ciudad::orderBy('ciudad')->get();
            $tipo_tarjetas = TipoTarjeta::orderBy('tipo_tarjeta')->get();
            $tipo_refrigerios = TipoRefrigerio::orderBy('tipo')->get();
            $categorias = CategoriaCompra::orderBy('categoria')->get();
            return Crypt::encrypt(
                json_encode(compact('user', 'roles', 'ciudades', 'tipo_tarjetas', 'tipo_refrigerios', 'categorias')),
                false
            );
            return response()->json(compact('user', 'roles', 'ciudades', 'tipo_tarjetas', 'tipo_refrigerios','categorias'));
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout($plataforma)
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out','logout'=>true]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function nuevoUsuario(Request $request)
    {
        $data= $request->except(['password','foto']);
        $usuarioExiste = User::where('email', '=', $request->get('email'))->first();
        $created=false;
        if ($usuarioExiste != null) {
            return response()->json(['created'=>$created,'error'=>'Usuario ya existe']);
        }
        $data['password']=bcrypt($request->get('password'));
        $usuario=User::create($data);
        if ($request->has('foto')) {
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        $usuario->assignRole('Usuarios');
        $created=true;
        if (! $token = JWTAuth::attempt(['email'=> $request->email, 'password' => $request->get('password')])) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        return response()->json(compact('token', 'created'));
    }

    public function registroPush(Request $request)
    {
        try {
            $data=array();
            if (! $user = auth('api')->user()) {
                return response()->json(['user_not_found'], 404);
            }
            if ($request->get('tipo')=='2') {
                $data['token_and']=$request->get('dispositivo');
            } else {
                $data['token_ios']=$request->get('dispositivo');
            }
            $user->update($data);
            return response()->json(['tokenSaved'=>true]);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function passForgot(Request $request)
    {
        $usuario = User::where('email', '=', Input::get('email'))->first();
        if ($usuario == null) {
            return response()->json(['error'=>'usuario no encontrado'], 401);
        } else {
            $password = Helpers::nuevoPassword();
            $data['password'] = bcrypt($password);
            $usuario->update($data);
            $info['nombre']=$usuario->nombre;
            $info['apellido']=$usuario->apellido;
            $info['cedula']=$usuario->cedula;
            $info['email']=$usuario->email;
            $info['password']=$password;
            // if (filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL)) {
            //     Mail::send('emails.remember', $info, function ($message){
            //         $message->subject('Contraseña Provicional');
            //         $message->to(Input::get('email'));
            //     });
            // }
        }
        return response()->json(['enviado'=>true]);
    }

    public function geoposicion(Request $request)
    {
        try {
            $data=array();
            if (! $user = auth('api')->user()) {
                return response()->json(['user_not_found'], 404);
            }
            $user->latitud=$request->get('latitud');
            $user->longitud=$request->get('longitud');
            $user->save();
            return response()->json(['created'=>true]);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
    }

    public function saldo()
    {
        return response()->json(['saldo'=>0]);
    }
}
