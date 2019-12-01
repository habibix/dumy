<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = "license";
    protected $fillable = ['license_type', 'license_camera'];
}
