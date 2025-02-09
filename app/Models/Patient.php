<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'gender',
        'phone_number',
    ];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function User()
    {
        return $this->hasOne(User::class);
    }
}
