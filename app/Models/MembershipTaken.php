<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipTaken extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_user_id',
        'membership_type_id',
        'starting_date',
        'end_date',
        'cost',
        'paid',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function membershipUser()
    {
        return $this->belongsTo(MembershipUser::class);
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class);
    }
}
