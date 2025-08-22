<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManeuverPayment extends Model
{
     protected $fillable = [
        'maneuver_id',
        'amount',
        'payment_method',
        'status',
        'created_by'
    ];

    public function maneuver()
    {
        return $this->belongsTo(Maneuver::class);
    }
}
