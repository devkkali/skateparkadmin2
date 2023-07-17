<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NormalCard extends Model
{
    use HasFactory;


    protected $fillable = [
        'card_id',
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
}
