<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = [
        'user_id',
        'specialist_id',
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

    public function Case()
    {
        return $this->hasMany(Cases::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
