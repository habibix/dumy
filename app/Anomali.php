<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anomali extends Model
{
    protected $table = "anomali";
    protected $fillable = ['anomali', 'camera_id'];

    function camera(){
        return $this->belongsTo('App\Camera');
    }
}
