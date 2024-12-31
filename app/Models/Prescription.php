<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    public function Institution()
    {
        return $this->belongsTo(Institution::class, 'TenantID');
    }

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class, 'RecordID');
    }
}
