<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $table = 'cases';

    protected $fillable = [
        'specialist_id',
        'patient_id',
        'isPrivate',
        'date',
        'notes',
        'treatment_plan',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'case_id');
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'case_symptoms');
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'case_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'case_id');
    }

}
