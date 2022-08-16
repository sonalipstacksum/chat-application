<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMessage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $users = User::all();
        
        return view('dashboard', compact('users'));
    }

    public function openChatWindow($id) {
        $user = User::findOrFail($id);
       
        $where_query = "1";
        $where_query .= " AND (sender_id = '".Auth::user()->id."' AND receiver_id = '".$id."' ";
        $where_query .= ')';
        $where_query .= " OR (receiver_id = '".Auth::user()->id."' AND sender_id = '".$id."' ";
        $where_query .= ')';
        $user_messages = UserMessage::whereRaw($where_query)->get();
        

        return view('chats.chat-window', compact('user', 'user_messages'));
    }

    public function sendMessage(Request $request) {
        echo "<pre>";
        print_r($request->all());
        die;
    }
}
