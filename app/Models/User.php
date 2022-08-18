<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Loan\Loan;
use Laravel\Sanctum\Sanctum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * Different Roles Of User.
     *
     * @var array<int, string>
     */
    public static $userRoles = [
        1 => 'User',
        2 => 'Admin'
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


    /**
     * Laravel Sanctum
     *
     * @return Relationship
     */
    public function tokens()
    {
        return $this->morphMany(Sanctum::$personalAccessTokenModel, 'tokenable', "tokenable_type", "tokenable_id");
    }

    /**
     * Get the Loans for User.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get role id by Value.
     */
    public static function getRoleIdByValue($statusValue)
    {
        return array_search($statusValue, self::$userRoles);
    }

    public static function getRoleKeys()
    {
        return array_keys(self::$userRoles);
    }
}
