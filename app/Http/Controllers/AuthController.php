<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }


    public function loginSubmit(Request $request)
    {
       //form validacao

       $request->validate(
        [
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16',
        ],
        [
            'text_username.required'=>'O username é obrigatório',
            'text_username.email'=>'O username deve ser um email válido',
            'text_password.required'=>'O userpassword é obrigatório',
            'text_password.min'=>'O userpassword deve ter no mínimo 6 carcteres',
            'text_password.max'=>'O userpassword deve ter no máximo 16 carcteres',
        ]
     );

        $username = $request->input('text_username');
        $userpassword = $request->input('text_password');

         //get user database 

         $user = User::where('username', $username)->where('deleted_at', NULL)->first();

         if(!$user){

            return redirect()->back()->withInput()->with('loginError', 'Username ou password inexistente!');

         }

            // checar password


        if(!password_verify($userpassword, $user->password)){

            return redirect()->back()->withInput()->with('loginError', 'Username ou password inexistente!');

            }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([

            'user'=> [
                'id'=> $user->id,
                'username'=> $user->username

            ]
            ]);


         return redirect()->to('/home')->with('success', 'Login efetuado com sucesso!');
      
    }



    public function logout()
    {
       session()->forget('user');
       return redirect()->to('/login');
    }
}
