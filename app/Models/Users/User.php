<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'nid_number',
        'income',
        'profession',
        'education',
        "avatar",
        "score",
        "parent_is_alive",
        "parent_available",
        "parent_profession",
        "spouse_is_alive",
        "spouse_name",
        "spouse_dob",
        "spouse_nid_number",
        "spouse_income",
        "spouse_profession",
        "spouse_education",
        "no_of_child",
        "children_profession",
        "own_house",
        "total_land",
        "house_made_of",
        "other_earning_member",
        "other_member_have_bank_account",
        "status",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value): ?string
    {
        if (!empty($value)) {
            return Storage::url($value);
        }
        return null;
    }
}
