<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTaken extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_user_id',
        'package_type_id',
        'starting_date',
        'end_date',
        'cost',
        'paid',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function packageUser()
    {
        return $this->belongsTo(packageUser::class);
    }

    public function packageType()
    {
        return $this->belongsTo(PackageType::class);
    }
}
