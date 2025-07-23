<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\ConTracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{

    public function index()
    {
          
        $id = session('user.id');
        // $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->get()->toArray();
     

        return view('home',['notes'=> $notes]);

    }


    public function newNote()
    {
        
     


    }


    public function editNote($id)
    {

       
         $id = Operations::decryptId($id);


    }

    public function deleteNote($id)
    {

        
        $id = Operations::decryptId($id);

    }


}