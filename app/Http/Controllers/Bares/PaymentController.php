<?php

namespace App\Http\Controllers\Bares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormaPago;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Crypt;

class PaymentController extends Controller
{
    public function saldo(Request $request){
        try {
            $user = User::find(base64_decode($request->get('alumno')));
            return Crypt::encrypt(json_encode(['saldo'=>$user->saldo]),false);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            //
        } 
    }

    public function cobrar(Request $request){
        $user = User::find(base64_decode($request->get('alumno')));
        $valor = base64_decode($request->get('valor'));
        if(!is_numeric($valor )){
            return response()->json(['error'=>'Ingrese un valor decimal'],404);
        }
        if($user->saldo>=$valor){
            $transaccion = Transaccion::create([
                'tipo_transaccion_id'=>1,
                'usuario_id'=>$user->id,
                'usuario_crea_id'=>Auth::user()->id,
                'fecha_hora'=>Carbon::now()->toDateTimeString(),
                'valor'=>$valor,
                'forma_pago_id'=>7,
                'institucion_id'=>Auth::user()->institucion_id
            ]);
            $user->saldo= $user->saldo - $transaccion->valor;
            $user->save();
            return response()->json(['realizado'=>true]);
        }else{
            return response()->json(['error'=>'Saldo insuficiente'],404);
        }
    }

    public function recargar(Request $request){
        $user = User::find(base64_decode($request->get('alumno')));
        $valor = base64_decode($request->get('valor'));
        if(!is_numeric($valor )){
            return response()->json(['error'=>'Ingrese un valor decimal'],404);
        }
        if($valor>0){
            $transaccion = Transaccion::create([
                'tipo_transaccion_id'=>2,
                'usuario_id'=>$user->id,
                'usuario_crea_id'=>Auth::user()->id,
                'fecha_hora'=>Carbon::now()->toDateTimeString(),
                'valor'=>$valor,
                'forma_pago_id'=>$request->get('forma_pago_id'),
                'institucion_id'=>Auth::user()->institucion_id
            ]);

            $user->saldo= $user->saldo + $transaccion->valor;
            $user->save();
            return response()->json(['realizado'=>true]);
        }else{
            return response()->json(['error'=>'Saldo insuficiente'],404);
        }
    }

    public function transacciones(){
        $transacciones = Transaccion::where('institucion_id',Auth::user()->institucion_id)->orderBy('fecha_hora','desc')->paginate(50);
        return Crypt::encrypt(json_encode(compact('transacciones')),false);//response()->json(compact('transacciones'));
    }

    public function transacciones_hoy(){
        $recargas = Transaccion::where('institucion_id',Auth::user()->institucion_id)
                ->whereBetween('fecha_hora',[Carbon::now()->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59'])
                ->whereHas('tipo_transaccion',function($query){
                    $query->where('operacion','+');
                })
                ->orderBy('fecha_hora','desc')->get();
        $cobros = Transaccion::where('institucion_id',Auth::user()->institucion_id)
                ->whereBetween('fecha_hora',[Carbon::now()->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59'])
                ->whereHas('tipo_transaccion',function($query){
                    $query->where('operacion','-');
                })
                ->orderBy('fecha_hora','desc')->get();
        return Crypt::encrypt(json_encode(['recargas'=>$recargas->sum('valor'),'cobros'=>$cobros->sum('valor')]),false);
        //return response()->json(['recargas'=>$recargas->sum('valor'),'cobros'=>$cobros->sum('valor')]);
    }

    public function forma_pago(){
        $formas = FormaPago::where('habilitado',1)->get();
        return response()->json(compact('formas'));
    }
}
