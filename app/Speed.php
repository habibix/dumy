<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Speed extends Model
{
    protected $table = "speed";
    protected $fillable = ['speed', 'camera_id', 'created_at', 'updated_at'];

    function camera(){
        return $this->belongsTo('App\Camera');
    }
}
