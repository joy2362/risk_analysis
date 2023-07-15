<?php

namespace App\Models\Users;

use App\Models\Child;
use App\Models\Member;
use App\Models\Residence;
use App\Models\Spouse;
use App\Models\UserOtherInfo;
use App\Models\UserParent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'gender',
        "avatar",
        "score"
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

    public function getAvatarAttribute($value)
    {
        if (!empty($value)) {
            return Storage::url($value);
        }
        return null;
    }

    public function child(): HasOne
    {
        return $this->hasOne(Child::class);
    }

    public function residence(): HasOne
    {
        return $this->hasOne(Residence::class);
    }

    public function other(): HasOne
    {
        return $this->hasOne(UserOtherInfo::class);
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    public function spouse(): HasOne
    {
        return $this->hasOne(Spouse::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(UserParent::class);
    }
}
