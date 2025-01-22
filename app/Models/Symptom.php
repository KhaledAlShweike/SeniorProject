<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = ['name', 'is_secret'];

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function cases()
    {
        return $this->belongsToMany(Cases::class, 'case_symptoms');
    }
}
