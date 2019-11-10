<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnomaliRekap extends Model
{
    protected $table = "anomali_rekap";
    protected $fillable = ['anomali_type', 'user_id', 'camera_id', 'anomali_type', 'total'];

    function camera()
    {
        return $this->belongsTo('App\Camera');
    }

    function user()
    {
        return $this->belongsTo('App\User');
    }
}
