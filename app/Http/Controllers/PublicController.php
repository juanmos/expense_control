<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PublicController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('home');
        }else{
            return view('web.index');
        }
        
    }
}
