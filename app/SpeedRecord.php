<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpeedRecord extends Model
{
    protected $table = "speed_record";
    protected $fillable = ['speed_record', 'vehicle', 'camera_id', 'created_at', 'updated_at'];

    function camera(){
        return $this->belongsTo('App\Camera');
    }
}
