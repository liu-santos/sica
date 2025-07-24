<?php

namespace App\Http\Controllers;

use App\Models\Note;
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

       return view('new_note');


    }

    public function newNoteSubmit(Request $request){

     //validate


     $request->validate(
        [
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
        ],
        [
            'text_title.required'=>'O Título é obrigatório',
            'text_title.min'=>'O Título deve ter no mínimo 3 caracteres',
            'text_title.max'=>'O Título deve ter no máximo 200 caracteres',
            'text_note.required'=>'A Nota é obrigatório',
            'text_note.min'=>'A Nota deve ter no mínimo 3 carcteres',
            'text_note.max'=>'A Nota deve ter no máximo 3000 carcteres',
        ]
     );

     //get user id

     $id = session('user.id');

     //create note

     $note = new Note();
     $note->user_id = $id;
     $note->title = $request->text_title;
     $note->text = $request->text_note;
     $note->save();

     return redirect()->route('home');


     //redirect

    }


    public function editNote($id)
    {

         $id = Operations::decryptId($id);
         echo "Estou editando id = $id";

    }

    public function deleteNote($id)
    {

        $id = Operations::decryptId($id);
        echo "Estou deletando id = $id";

    }


}
