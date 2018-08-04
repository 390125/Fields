<?php

namespace App\Http\Controllers\Talk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\RoomsManeger;

class RoomController extends Controller
{
    /**
     * contents repo instance
     */
    protected $rooms;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // �����Ń��O�C���F�ؒ��̐l�̂ݓ������悤�ɂ��Ă����B
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // 入室後のルームのみ最新から表示する（where・join追加）
        $rooms = Room::join('rooms_manegers', 'rooms.room_id', '=', 'rooms_manegers.room_id')
        ->orderBy('created_at', 'desc')
        ->select('rooms.*', 'rooms_manegers.user_id')
        ->where('rooms_manegers.user_id', $user->user_id)
        ->get();
        return view('talks.rooms', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     * Just Move to Form View
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('talks.createroom');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * (@return \Illuminate\Http\Response)
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // バリデーションチェック
        // ルー名、詳細は必須
        $validatedData = $request->validate([
            'room_name' => 'required',
            'room_description' => 'required'
        ]);

        $room = Room::firstOrCreate(
            [
                'create_user_id' => $user->user_id,
                'room_name' => $request->room_name,
                'room_description' => $request->room_description,
                'created_at' => Carbon::now(),
                'updated_at'  => Carbon::now(),
                'location' => DB::raw("(GeomFromText('POINT($request->lat $request->lng)'))")
            ]
        );

        DB::table('rooms_manegers')->insert(
            ['user_id' => $user->user_id,
            'room_id' => $room->room_id,
            'created_at' => Carbon::now(),
            'updated_at'  => Carbon::now()]
        );

        // $room = Room::find($id);
        // $room->location = ['lat' => $request->lat,'lng' => $request->lng];

        $rooms = Room::orderBy('created_at')->get();

        return redirect('rooms');

    }

    /**
     *
     * Find rooms
     * 近くのルームを表示一覧
     *
     */
     public function find()
     {
         $user = Auth::user();

         // 自分参加していないルームのみ表示
         $rooms = DB::table('rooms')->select('rooms.*', 'rooms_manegers.user_id')
         ->orderBy('created_at', 'desc')
         ->leftJoin('rooms_manegers', 'rooms.room_id', '=', 'rooms_manegers.room_id')
         ->get();

         $deleteRooms =array();
         $findrooms = array();

         foreach ($rooms as $key => $room) {
             // ログイン中のIDが含まれるレコードを削除し、そのルームIDを取得
             if ($room->user_id == $user->user_id) {
                 array_push($deleteRooms, $room->room_id);
                 //unset($rooms[$key]);
             }
             // // 該当ルームIDが含まれる場合は削除
             // if (in_array($room->room_id, $deleteRooms)) {
             //     unset($rooms[$key]);
             // }
         }

         foreach ($rooms as $key => $room) {
             if ($room->user_id != $user->user_id &&
                !(in_array($room->room_id, $deleteRooms)) &&
                !(in_array($room, $findrooms))) {
                 array_push($findrooms, $room);
             }
             //array_push($findrooms, $room);
         }

         return view('talks.findroom', ['rooms' => $findrooms]);
     }

    /**
     *
     * Entry to new Room
     * 入室処理
     *
     */
     public function entryRoom($id)
     {
         $user = Auth::user();

         // ルーム管理テーブルに登録
         $room_maneger = new RoomsManeger;
         $room_maneger->user_id = $user->user_id;
         $room_maneger->room_id = $id;
         $room_maneger->save();

         $contents = DB::table('contents')
             ->join('users', 'contents.user_id', '=', 'users.user_id')
             ->select('contents.*', 'users.user_name')
             ->where('room_id', $id)
             ->orderBy('updated_at')
             ->get();

         //return view('talks.content', ['contents' => $contents, 'room_id' => $id]);
         //eturn redirect()->route('profile', ['id' => 1]);
         return redirect()->action(
             'Talk\ContentController@show', ['id' => $id]
         );
     }

     /**
      *
      * Entry to new Room
      * 退室処理
      *
      */
      public function exitRoom($id)
      {
          $user = Auth::user();

          // ルーム管理レコードを削除
          $delete_room_maneger = DB::table('rooms_manegers')
          ->where('user_id', $user->user_id)
          ->where('room_id', $id)
          ->delete();

          return redirect()->action(
              'Talk\RoomController@index'
          );
      }

}
