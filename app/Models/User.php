<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class user extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'first_name', 'last_name', 'user_name', 'email', 'password', 'birthdate', 'gender', 'bio', 'profile_pic_url'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = ['password'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function queries()
    {
        return $this->hasMany(Query::class);
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
