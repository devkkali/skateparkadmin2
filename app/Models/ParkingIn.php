<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'card_id',
        'name',
        'phone_no',
        'deposite',
        'in_time',
        'out_time',
        'interval',
        'paid_amount',
        'sock_cost_at_time',
        'water_cost_at_time',
        'socks',
        'water',
        'no_of_client',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function parkingInGroup()
    {
        return $this->hasMany(ParkingInGroup::class);
    }
}
