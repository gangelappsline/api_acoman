<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManeuverContainer extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'maneuver_id',
        'code',
        'license_plate',
    ];
}
