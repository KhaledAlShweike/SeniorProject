<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name', 'last_name', 'user_name', 'email', 'password', 'birthdate', 'gender', 'bio', 'profile_pic_url'
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
}
