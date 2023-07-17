<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'validity_in_day',
        'cost',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function packageTaken()
    {
        return $this->hasMany(PackageTaken::class);
    }
}
