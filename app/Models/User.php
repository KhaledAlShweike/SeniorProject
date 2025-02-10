<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $connection = 'ehr';

    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'password',
        'birthdate',
        'gender',
        'role',
        'status',
        'profile_pic_url'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = ['password'];

    public function Patient()
    {
        return $this->hasOne(Patient::class); //
    }

    public function Contact()
    {
        return $this->hasMany(Contact::class); //
    }

    public function Specialist()
    {
        return $this->hasOne(Specialist::class); //
    }

    public function Role()
    {
        return $this->hasMany(Role::class); //
    }

    public function Queries()
    {
        return $this->hasMany(Query::class); //
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
