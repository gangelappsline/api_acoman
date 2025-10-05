<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManeuverExtension extends Model
{
    protected $fillable = [
        'maneuver_id',
        'type',
        'days',
        'total',
        'file',
        'paid',
        'notes',
        'created_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
