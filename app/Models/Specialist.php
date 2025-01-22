<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = [
        'first_name',
        'last_name',
        'degree',
        'specialization',
        'bio',
        'certified',
        'institution_id'
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function cases()
    {
        return $this->hasMany(Cases::class, 'specialist_id');
    }

    public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}

}
