<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'birthdate', 'gender', 'phone_number'];

    public function cases()
    {
        return $this->hasMany(Cases::class);
    }

    public function queries()
    {
        return $this->hasMany(Query::class);
    }
}
