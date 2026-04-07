<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //

     public function login (Request $request){
        $credentials = $request->validate([
         'email' => ['required' , 'email'],
         'password' => ['required']
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();


            return redirect()->intended('dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match the records' ,
            'password' => 'Password incorrect'
        ]);
    }


    public function showLogin(){
        return view('login');
    }
 
}
