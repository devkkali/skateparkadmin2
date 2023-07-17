<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingInGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parking_in_id',
        'in_time',
        'out_time',
        'interval',
    ];

    public function parkingIn()
    {
        return $this->belongsTo(ParkingIn::class);
    }
}

