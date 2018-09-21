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
use App\Facades\Distance;

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
        // ルーム名、詳細は必須
        $validatedData = $request->validate([
            'room_name' => 'required',
            'room_description' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'room_distance' => 'required'
        ]);

        $room = Room::firstOrCreate(
            [
                'create_user_id' => $user->user_id,
                'room_name' => $request->room_name,
                'room_description' => $request->room_description,
                'created_at' => Carbon::now(),
                'updated_at'  => Carbon::now(),
                'location' => DB::raw("(GeomFromText('POINT($request->lat $request->lng)'))"),
                'room_distance' => $request->room_distance
            ]
        );

        DB::table('rooms_manegers')->insert(
            ['user_id' => $user->user_id,
            'room_id' => $room->room_id,
            'created_at' => Carbon::now(),
            'updated_at'  => Carbon::now()]
        );

        $rooms = Room::orderBy('created_at')->get();

        return redirect('rooms');
    }

    /**
     *
     * Find
     * ルーム検索用画面表示
     *
     */
     public function find()
     {
         // 返却用ルーム初期化
         $rooms = array();

         return view('talks.findroom', ['rooms' => $rooms]);
     }

     /**
      *
      * Find rooms
      * 近くのルーム検索->表示
      *
      */
      public function findRoom(Request $request)
      {
          $user = Auth::user();

          // 自分参加していないルームのみ表示
          $rooms = DB::table('rooms')->select('rooms.*', 'rooms_manegers.user_id')
          ->orderBy('created_at', 'desc')
          ->leftJoin('rooms_manegers', 'rooms.room_id', '=', 'rooms_manegers.room_id')
          ->get();

          $deleteRooms = array();
          $findrooms = array();
          $aroudrooms = array();

          // ログイン中のuserIdが含まれるレコードを取得し、削除用リストに詰める
          foreach ($rooms as $key => $room) {
              if ($room->user_id == $user->user_id) {
                  array_push($deleteRooms, $room->room_id);
              }
          }

          // 削除対象に含まれず、リスト内に重複しない場合findRoomに詰める
          foreach ($rooms as $key => $room) {
              if ($room->user_id != $user->user_id &&
                 !(in_array($room->room_id, $deleteRooms)) &&
                 !(in_array($room, $findrooms))) {
                  array_push($findrooms, $room);
              }
          }
          $lat1 = $request->lat;
          $lng1 = $request->lng;

          foreach ($findrooms as $key => $room) {
              $roomWithLatLong = Room::latlong()->find( $room->room_id, array(DB::raw('room_id, room_name, AsText(location) AS location')));
              $lat2 = $roomWithLatLong->lat;
              $lng2 = $roomWithLatLong->lng;
              $distance = Distance::distance($lat1, $lng1, $lat2, $lng2);
              if ($distance < 100000 ) {
                  array_push($aroudrooms, $room);
              }
          }
         return view('talks.findroom', ['rooms' => $aroudrooms]);
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
