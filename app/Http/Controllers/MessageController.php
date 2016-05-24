<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Message;
use App\Conversation;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function message()
    {
        $userID = Auth::user()->id;

        $conversation = Conversation::where('user1', $userID)->orWhere('user2', $userID)->orderBy('date', 'desc')->get();

        if (count($conversation)==0)
        {
            $msg = null;
            //dd($conversation);
        }
        else{
            //dd($conversation);
            $msg = Message::where('conversationID', $conversation->first()->id)->get();
        }


        //dd($conversation);

        return view('message.message', [
            'conversation' => $conversation,
            'msg' => $msg,
        ]);
    }

    public function showMessage($key)
    {
        $userID = Auth::user()->id;
        $conversation = Conversation::where('user1', $userID)->orWhere('user2', $userID)->orderBy('date', 'desc')->get();
        $con = Conversation::where('key', $key)->first();
        $msg = Message::where('conversationID', $con->id)->get();

        return view('message.showMessage', [
            'conversation' => $conversation,
            'msg' => $msg,
            'con' => $con,
        ]);
    }


    public function save(Request $request)
    {
        $user1 = Auth::user()->id;
        $user2 = $request->input('userID');
        $msg = $request->input('message');

        $matchThese = ['user1' => $user1, 'user2' => $user2];
        $orThose = ['user1' => $user2, 'user2' => $user1];

        $c = Conversation::where($matchThese)->orWhere($orThose)->first();

        if (empty($c)) {
            $Conversation = new Conversation;
            $Conversation->user1 = $user1;
            $Conversation->user2 = $user2;
            $Conversation->date = time();
            $Conversation->key = uniqid();
            $Conversation->save();

            $Message = new Message;
            $Message->conversationID = $Conversation->id;
            $Message->message = $msg;
            $Message->senderID = $user1;
            $Message->read1 = 1;
            $Message->read2 = 0;
            $Message->date = time();
            $Message->save();

        } else {
            $c->date = time();
            $c->save();

            $Message = new Message;
            $Message->conversationID = $c->id;
            $Message->message = $msg;
            $Message->senderID = $user1;

            if ($c->user1 == $user1) {
                $Message->read1 = 1;
                $Message->read2 = 0;
            } elseif ($c->user2 == $user1) {
                $Message->read1 = 0;
                $Message->read2 = 1;
            }

            $Message->date = time();
            $Message->save();

        }


        //return redirect()->back()->with('success', '<strong>Świetnie!</strong> Wiadomość została wysłana!');
        return redirect()->route('message');

    }


}
