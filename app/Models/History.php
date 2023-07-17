<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'recorded_time',
        'card_id',
        'name',
        'phone_no',
        'no_of_client',
        'socks',
        'sock_cost_at_time',
        'sock_cost_total',
        'water',
        'water_cost_at_time',
        'water_cost_total',
        'in_time',
        'out_time',
        'interval',
        'paid_amount',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
