<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtherInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'other_earning_member',
        'other_member_have_bank_account',
        'user_id',
    ];
}
