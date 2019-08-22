<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counting extends Model
{
    protected $table = "counting";
    protected $fillable = ['vehicle', 'count', 'camera', 'created_at', 'updated_at'];
}
