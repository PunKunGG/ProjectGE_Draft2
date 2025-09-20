<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgetPasswordManager extends Controller
{
    //
    function forgetPassword(){
        return view('forget-password');
    }
    function forgetPasswordPost(Request $request){
        
    }
}
