<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'TenantID');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_tenant', 'TenantID', 'DoctorID');
    }

    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'TenantID');
    }
}
