<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }


    public function loginSubmit(Request $request)
    {
       //form validacao

       $request->validate([
            'text_username' => 'required|string|max:5|min:3',
            'text_password' => 'required|string|min:6',
        ]);

        $username = $request->input('text_username');
        $userpassword = $request->input('text_password');
   
        echo '0k';
   //aula 44
    }


    public function logout()
    {
        echo'logout';
    }
}
