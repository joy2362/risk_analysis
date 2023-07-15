<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_alive',
        'name',
        'dob',
        'nid_number',
        'income',
        'profession',
        'education',
        'gender',
        'user_id',
    ];
}
