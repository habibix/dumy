<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $table = "camera";
    protected $fillable = ['wilayah', 'lokasi', 'ip_camera', 'user_id', 'updated_at', 'created_at'];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function camera_setting()
    {
        return $this->hasOne('App\User');
    }
}
