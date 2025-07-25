<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\ConTracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Laravel\Prompts\Note as PromptsNote;

class MainController extends Controller
{

    public function index()
    {

        $id = session('user.id');
        // $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();


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

         $note = Note::find($id);

         return view('edit_note',['note'=>$note ]);

    }

    public function editNoteSubmit(Request $request)
    {
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


        //checar se o id existe

        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        //decryption

        $id = Operations::decryptId($request->note_id);

        $note = Note::find($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');

    }

    public function deleteNote($id)
    {

        $id = Operations::decryptId($id);
      //careegar nota

      $note = Note::find($id);

      return view('delete_note', ['note'=> $note]);

    }

    public function deleteNoteConfirm($id)
    {

        $id = Operations::decryptId($id);
      //careegar nota

        $note = Note::find($id);

        // hard delete

        // $note->delete();

        // soft delete

        $note->deleted_at= date('Y:m:d H:i:s');
        $note->save();


         // soft forcedelete
        // $note->forceDelete();

        return redirect()->route('home');
    }


}
