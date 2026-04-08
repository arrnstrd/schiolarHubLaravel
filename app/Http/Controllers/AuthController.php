<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PDO;

class AuthController extends Controller
{


public function showRegister() {
    return view('register');
}

    //code here lol
    public function register(Request  $request){
        $incopmingFields= $request->validate(
           [//                                                   users table, in the name field
            'name' => ['required' , 'min:5'  , Rule::unique('users', 'name')],
            'email' => ['required' , 'email'],
            'password' => ['required', 'min:10' ]
           ]
        );


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

       return redirect('/notice')->with('success', 'Registered successfully! Please login.');


    }

}


