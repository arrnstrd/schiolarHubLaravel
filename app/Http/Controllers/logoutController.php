<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    //

    public function logout(Request $request){
        Auth::logout();

        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
