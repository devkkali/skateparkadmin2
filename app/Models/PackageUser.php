<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageUser extends Model
{
    use HasFactory;


    protected $fillable = [
        'card_id',
        'name',
        'phone_no',
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
    
    public function packageTaken()
    {
        return $this->hasMany(PackageTaken::class);
    }

    public function packageType()
    {
        return $this->hasManyThrough(
            packageType::class,
            PackageTaken::class
        );
    }
    // public function districts()
    // {
    //     return $this->hasManyThrough(
    //         District::class,
    //         Province::class
    //     );
    // }
}
