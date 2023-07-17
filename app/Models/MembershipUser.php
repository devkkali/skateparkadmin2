<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipUser extends Model
{
    use HasFactory;


    protected $fillable = [
        'card_id',
        'name',
        'phone_no',
    ];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function membershipTaken()
    {
        return $this->hasMany(MembershipTaken::class);
    }

    public function membershipType()
    {
        return $this->hasManyThrough(
            membershipType::class,
            membershipTaken::class
        );
    }

}
