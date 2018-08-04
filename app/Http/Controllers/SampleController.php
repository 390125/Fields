<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Users;

class SampleController extends Controller
{
    public function __construct()
    {
        // これでログイン認証中の人のみ入れるようにしている。
        $this->middleware('auth');
    }
    
    // モデルアクション（メソッド）
    public function model()
    {
      // 作成したモデルのインスタンス化
      $md = new Users();
      
      // データ取得
      $data = $md->getData();

      // ビューを返す
      return view('sample.model', ['data' => $data]);
    }
    
    // パラメータ付きアクション
    public function type($type=nul) //タイプパラメータが無い場合にも対応する為に、初期値にnullを指定している
    {
      // 作成したモデルのインスタンス化
      $md = new Users();
      
      // データ取得
      $data = $md->getDataByParam($type);

      // ビューを返す 
      return view('hasparam', ['data' => $data]);
    }
}