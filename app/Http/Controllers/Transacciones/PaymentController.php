<?php

namespace App\Http\Controllers\Transacciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormaPago;
use App\Models\Transaccion;
use App\Models\Institucion;
use App\Models\Tarjeta;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Crypt;

class PaymentController extends Controller
{
    public function saldo(Request $request,$completo=null){
        try {

            $user = User::find(base64_decode($request->get('alumno')));
            if($completo==null) return Crypt::encrypt(json_encode(['saldo'=>$user->saldo]),false);
            
            $institucion = Institucion::find(Auth::user()->institucion_id);
            $hoy = Carbon::now()->toDateTimeString();
            $menos30 =Carbon::now()->subDays(30)->toDateString().' 00:00:00';
            $recargas =$institucion->transacciones()//->whereBetween('fecha_hora',[$menos30,$hoy])
                                    ->where('usuario_id',$user->id)
                                    ->where('tipo_transaccion_id',2)->get();
            $compras =$institucion->transacciones()//->whereBetween('fecha_hora',[$menos30,$hoy])
                                    ->where('usuario_id',$user->id)
                                    ->where('tipo_transaccion_id',1)->get();
            return Crypt::encrypt(json_encode(['saldo'=>$user->saldo,'recargas'=>$recargas->sum('valor'),'compras'=>$compras->sum('valor')]),false);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            //
        } 
    }

    public function validaTarjeta(Request $request){
        $tarjeta_id=$request->get('tid');
        $tarjeta = Tarjeta::find(base64_decode($tarjeta_id));
        if($tarjeta==null){
            return response()->json(['error'=>'Tarjeta no existe'],404);
        }
        if ($tarjeta->perdida){
            return response()->json(['valida'=>false,'mensaje'=>'La tarjeta ha sido reportada como perdida el '.Carbon::parse($tarjeta->fecha_perdida)->format('d-m-Y')]);
        }
        if(Carbon::now()->isBefore(Carbon::parse($tarjeta->fecha_vencimiento))){
            return response()->json(['valida'=>true]);
        }else{
            return response()->json(['valida'=>false,'mensaje'=>'La tarjeta ha vencido el '.Carbon::parse($tarjeta->fecha_vencimiento)->format('d-m-Y')]);
        }

    }

    public function cobrar(Request $request){
        
        $valor = base64_decode($request->get('valor'));
        if(!is_numeric($valor )){
            return response()->json(['error'=>'Ingrese un valor decimal'],404);
        }
        $user = User::find(base64_decode($request->get('alumno')));
        $institucion = Institucion::find(Auth::user()->institucion_id);
        if($user->saldo>=$valor){
            $transaccion = $institucion->transacciones()->create([
                'tipo_transaccion_id'=>1,
                'usuario_id'=>$user->id,
                'usuario_crea_id'=>Auth::user()->id,
                'fecha_hora'=>Carbon::now()->toDateTimeString(),
                'valor'=>$valor,
                'forma_pago_id'=>7,
                'tarjeta_id'=>base64_decode($request->get('tarjeta_id')),
                'usuario_crea_ip'=>$request->ip(),
                //'dispositivo'->$request->get('mac'),
                // 'telefono_uuid'->$request->get('uuid')
            ]);
            $user->saldo= $user->saldo - $transaccion->valor;
            $user->save();
            return response()->json(['realizado'=>true]);
        }else{
            return response()->json(['error'=>'Saldo insuficiente'],404);
        }
    }

    public function carga(Request $request){
        
        $user = Institucion::find(1);
        $user->transacciones()->create([
            'tipo_transaccion_id'=>1,
            'usuario_id'=>3,
            'usuario_crea_id'=>1,
            'fecha_hora'=>Carbon::now()->toDateTimeString(),
            'valor'=>10,
            'forma_pago_id'=>7,
            'usuario_crea_ip'=>$request->ip(),
            //'ubicacion'=>'23.2930320423,-93.230492492'
            //'telefono_uuid'=>random_bytes(36)
        ]);
    }

    public function recargar(Request $request){
        
        $valor = base64_decode($request->get('valor'));
        if(!is_numeric($valor )){
            return response()->json(['error'=>'Ingrese un valor decimal'],404);
        }
        $user = User::find(base64_decode($request->get('alumno')));
        $institucion = Institucion::find(Auth::user()->institucion_id);
        if($valor>0){
            $transaccion = $institucion->transacciones()->create([
                'tipo_transaccion_id'=>2,
                'usuario_id'=>$user->id,
                'usuario_crea_id'=>Auth::user()->id,
                'fecha_hora'=>Carbon::now()->toDateTimeString(),
                'valor'=>$valor,
                'forma_pago_id'=>$request->get('forma_pago_id'),
                'tarjeta_id'=>base64_decode($request->get('tarjeta_id')),
                'usuario_crea_ip'=>$request->ip(),
                // 'dispositivo'->$request->get('mac'),
                // 'telefono_uuid'->$request->get('uuid')
            ]);

            $user->saldo= $user->saldo + $transaccion->valor;
            $user->save();
            return response()->json(['realizado'=>true]);
        }else{
            return response()->json(['error'=>'Saldo insuficiente'],404);
        }
    }

    public function transacciones(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $transacciones = $institucion->transacciones()->orderBy('fecha_hora','desc')->paginate(50);
        return Crypt::encrypt(json_encode(compact('transacciones')),false);//response()->json(compact('transacciones'));
    }

    public function transacciones_hoy(){
        $institucion = Institucion::find(Auth::user()->institucion_id);
        $recargas = $institucion->transacciones()
                ->whereBetween('fecha_hora',[Carbon::now()->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59'])
                ->whereHas('tipo_transaccion',function($query){
                    $query->where('operacion','+');
                })
                ->orderBy('fecha_hora','desc')->get();
        $cobros = $institucion->transacciones()
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
