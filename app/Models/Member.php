<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dob',
        'nid_number',
        'income',
        'profession',
        'gender',
        'education',
        'user_id',
    ];
}
