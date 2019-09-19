<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Macet extends Model
{
    protected $table = "macet";
    protected $fillable = ['camera_id', 'image', 'video'];

    function camera(){
        return $this->belongsTo('App\Camera');
    }
}
