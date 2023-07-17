<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone_no',    
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
