<?php

namespace App\Http\Controllers\Talk;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Content;
use App\Models\Room;
use App\Models\User;

use App\Http\Controllers\Talk\RoomController;

class ContentController extends Controller
{
    /**
     * contents repo instance
     */
    protected $contents;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Restriction to access
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::orderBy('created_at')->get();

        return view('talks.content', ['contents' => $contents]);
    }

    /**
     * Show the form for creating a new resource.
     * Just Move to Form View
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        /*$this->validate($request, [
            'content' => 'required',
        ]);*/


        $validatedData = $request->validate([
            'content' => 'required'
        ]);


        $content = new Content;
        $content->user_id = $user->user_id;
        $content->room_id = $request->room_id;
        $content->content = $request->content;
        $content->save();

        return redirect()->route('contents.show', $request->room_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        // チェック処理
        $isRequirement = DB::table('rooms_manegers')
            ->select('*')
            ->where('room_id', $id)
            ->where('user_id', $user->user_id)
            ->get();

        if (count($isRequirement) > 0) {
            // 取得処理
            $contents = DB::table('contents')
                ->join('users', 'contents.user_id', '=', 'users.user_id')
                ->select('contents.*', 'users.user_name')
                ->where('room_id', $id)
                ->orderBy('updated_at')
                ->get();

            //$room = Room::find($id);
            $room = Room::latlong()->find( $id, array(DB::raw('room_id, room_name, AsText(location) AS location')));



            //$distance = $this->getDistanceFromTwoLocate();

            return view('talks.content', ['contents' => $contents, 'room' => $room]);
        } else {
            return redirect('/find');
        }

    }

    public function getDistanceFromTwoLocate()
    {
        $room1 = Room::latlong()->find( 22, array(DB::raw('room_id, room_name, AsText(location) AS location')));
        $room2 = Room::latlong()->find( 26, array(DB::raw('room_id, room_name, AsText(location) AS location')));

        $query = DB::select(DB::raw("select Glength(GeomFromText('LineString($room1->lng $room1->lat, $room2->lng $room2->lat)')) * 112.12 * 1000 AS distance"));
        return $query;
    }

}
