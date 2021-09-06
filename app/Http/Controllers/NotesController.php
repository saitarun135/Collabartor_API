<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notes;
use App\Http\Controllers\Controller;
use App\Notes as AppNotes;
use App\User;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotesController extends Controller
{
    public function create_Note(Request $request)
    {
        $note=new AppNotes();        
        $note->title=$request->input('title');
        //$note->body=$request->input('body'); 
        // $note->MailColab=$request->input('MailColab');    
        $token = JWTAuth::getToken();
        $id = JWTAuth::getPayload($token)->toArray();
        $note->user_id = $id["sub"]; 
        $user_mail=User::where('id',$note->user_id)->value('email');
        $note->createdBy=$user_mail;
        $note->save();
        return $note;
    }
    
    public function getNotes()
    {
        $notes=AppNotes::all();
        $token = JWTAuth::getToken();
        $id = JWTAuth::getPayload($token)->toArray();        
        $check_id=$id["sub"];
        $Normal_notes=User::find($notes->user_id=$check_id )->noteses;
        $email=User::where('id',$check_id)->value('email');
        if($notes->user_id=$check_id){
            return response()->json(['notes'=>$Normal_notes,
        'collabNotes'=>AppNotes::where('assignedTo',$email)->get()]);
        }
    }

    public function collabNotes(Request $request){
        $id=$request->input('id');
        $email=$request->input('email');
        $verify=User::where('email',$email)->value('email');
        if(!$verify){
            return response()->json(['Alert'=>"email is not registered"]);
        }
        $Target_note=AppNotes::findOrFail($id);
        $token = JWTAuth::getToken();
        $id_getter = JWTAuth::getPayload($token)->toArray();   
        $check_id=$id_getter["sub"];
        if($email==$verify){
            if($Target_note->user_id=$check_id ){
                // $note=AppNotes::where('id',$id)
                // ->update(array('MailColab'=>$request->input('email')));
                //$value_added=AppNotes::where('id',$id)->update(array('collabarator'=>'1'));
                $assignedValue=AppNotes::where('id',$id)->update(array('assignedTo'=>$email));
                return response()->json(['success'=>"Email added successfully"]);
            }
        }
    }

    public function removeCollabarator(Request $request){
        $id=$request->input('id');
        $Target_note=AppNotes::findOrFail($id);
        $token = JWTAuth::getToken();
        $id_getter = JWTAuth::getPayload($token)->toArray();   
        $check_id=$id_getter["sub"];
        if($Target_note->user_id=$check_id ){
            // $note=AppNotes::where('id',$id)->update(array('MailColab'=>null));
            $value_removed=AppNotes::where('id',$id)->update(array('assignedTo'=>null));
            return response()->json(['message'=>"Email removed successfully"]);
        }   
        else {
            return response()->json(['Alert'=>"Id is not available"]);
        }
    }
   
}
