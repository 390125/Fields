<?php

namespace App\Http\Controllers\Auth;

use App\models\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // get login account
        $user = User::find(Auth::user()->user_id);

        // 画像アップロード処理
        $filename = $request->file('image')->getClientOriginalName();
        //$filename = $request->image;
        //$filename->store('public/img/users');
        $request->file('image')->storeAs('public/img/temp', $filename);

        // ディレクトリ確認し、存在しなければ作成
        $directory = "/public/img/users/" .$user->user_id . "/";
        if ( file_exists($directory)) {
            mkdir($directory);
        }

        // フォルダ内のファイルを削除
        $files = glob(storage_path("app/public/img/users/" .$user->user_id . "/". "*"));
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }

        // フォルダ移動
        Storage::move('public/img/temp/'.$filename, $directory.'/'.$filename);

        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->icon_path = 'img/users/'. $user->user_id . "/" .$filename;
        $user->save();

        return redirect('setting/' . $user->user_id)->with('status', __('更新しました！'));
        //return view('talks.setting')->with('status', __('更新しました！'));
    }
}
