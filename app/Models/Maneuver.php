<?php

namespace App\Models;

use App\Traits\SendsNotifications;
use Illuminate\Database\Eloquent\Model;

class Maneuver extends Model
{
    use SendsNotifications;

    protected $fillable = [
        'pediment',
        'patent',
        'container',
        'product',
        'country',
        'bulks',
        'presentation',
        'importer',
        'folio_200',
        'folio_500',
        'company',
        'created_by',
        'client_id',
        'programming_date',
    ];

    protected $casts = [
        'id' => 'integer',
        'patent' => 'string',
        'bulks' => 'float',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(ManeuverPayment::class);
    }

    public function files()
    {
        return $this->hasMany(ManeuverFile::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    public function checkInUser()
    {
        return $this->belongsTo(User::class, 'user_check_in');
    }

    public function checkOutUser()
    {
        return $this->belongsTo(User::class, 'user_check_out');
    }
}
