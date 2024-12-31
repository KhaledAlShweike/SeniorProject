<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    public function tenant()
    {
        return $this->belongsTo(Institution::class, 'TenantID');
    }

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class, 'PatientID');
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'DiseaseID');
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class, 'SymptomID');
    }
}
