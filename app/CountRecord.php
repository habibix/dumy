<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountRecord extends Model
{
    protected $table = "count_record";
    protected $fillable = ['vehicle', 'dimensi', 'camera_id', 'created_at', 'updated_at'];

    function camera(){
        return $this->belongsTo('App\Camera');
    }
}
