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

    protected $fillable = array(
        'create_user_id',
        'room_name',
        'room_description',
        'location',
        'room_distance'
    );

    // 経度と緯度を取得する
    public function scopeLatlong($query)
    {
        return $query->select(array('*', DB::raw('X(location) as `lat`'), DB::raw('Y(location) as `lng`')));
    }

}
