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
            $decrypted = Crypt::decrypt($request->get('alumno'));
            $user = User::find(base64_decode($decrypted));
            dd($user);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
            //
        }
        
    }
}
