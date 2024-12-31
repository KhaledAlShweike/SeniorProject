<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public function institution()
    {
        return $this->belongsToMany(Institution::class, 'doctor_tenant', 'DoctorID', 'TenantID');
    }
}
