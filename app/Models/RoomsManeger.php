<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomsManeger extends Model
{
    // 複合キー
    protected $primaryKey = ['roome_id', 'user_id'];
    // increment無効化
    public $incrementing = false;

    public $timestamps = true;

}
