<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManeuverData extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'maneuver_id',
        'data_key',
        'data_value',
    ];

    public function maneuver()
    {
        return $this->belongsTo(Maneuver::class);
    }
}
