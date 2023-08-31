<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function ShowChat()
    {
        return view('chat.show-chat');
    }
    public function SendMessage(Request $request)
    {
        $request->validate([
            'message'=>'required'
        ]);


        broadcast(new SendMessageEvent($request->user(), $request->message));
        return response()->json([$request->user(), $request->message]);
    }
}
