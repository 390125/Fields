<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    /**
     * ROOM_ID
     *
     * @var int
     */
    protected $primaryKey = 'room_id';

    public $timestamps = true;

    protected $geofields = array('location');

    protected $fillable = array('create_user_id', 'room_name', 'room_description', 'location');

    // 経度と緯度を取得する
    public function scopeLatlong($query)
    {
        return $query->select(array('*', DB::raw('X(location) as `lat`'), DB::raw('Y(location) as `lng`')));
    }

    // 2点間の距離を取得する
    public function getDistanceFromTwoLocate()
    {
        $room1 = latlong()->find( 22, array(DB::raw('room_id, room_name, AsText(location) AS location')));
        $room2 = latlong()->find( 26, array(DB::raw('room_id, room_name, AsText(location) AS location')));

        $query = DB::raw("SELECT Glength(GeomFromText('LineString($room1->lng $room1->lat, $room2->lng $room2->lat)')) * 112.12 * 1000 AS distance");
        return $query->distance;
    }

}
