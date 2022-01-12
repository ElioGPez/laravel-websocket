<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\SendMessageEvent;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chats');
    }

    public function getMessages(){
        return Message::with('user')->get();
    }
    public function saveMessage(Request $request){
        $userId = auth()->user()->id;
        $message = new Message();
        $message->user_id = $userId;
        $message->message = $request->message;
        $message->save();

        broadcast(new SendMessageEvent($message->load('user')))->toOthers();

        return ["status" => "success"];
    }
}
