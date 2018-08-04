<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array();
        $data['content'] = '文字化ける';

        return view('chatroom', ['data' => $data]);
    }

    public function post()
    {
        $data = array();
        $data['content'] = 'これか';

        return view('chatroom', ['data' => $data]);
    }
}
