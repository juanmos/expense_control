<?php

namespace App\Http\Controllers\Bares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
}
