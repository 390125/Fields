<?php

namespace App\Http\Controllers\Auth;

use App\models\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setUser()
    {
        $user = Auth::user();
        return view('talks.setting');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // バリデーションチェック
        $validatedData = $request->validate([
            'user_name' => 'required',
            'email' => 'required'
        ]);

        $user = User::find(Auth::user()->user_id);
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->save();

        return redirect('setting/' . $user->user_id)->with('status', __('更新しました！'));
        //return view('talks.setting')->with('status', __('更新しました！'));
    }
}
