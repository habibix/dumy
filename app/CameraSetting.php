<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CameraSetting extends Model
{
    protected $table = "camera_meta";
    protected $fillable = ['camera_id', 'area_capture', 'area_khusus', 'speed', 'counting', 'crossing', 'restricted_area', 'stopped'];

    function camera()
    {
        return $this->belongsTo('App\Camera');
    }
}
