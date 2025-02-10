<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $connection = 'ehr';

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
