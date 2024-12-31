<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'TenantID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function medicalImages()
    {
        return $this->hasMany(MedicalImage::class, 'RecordID');
    }
}
