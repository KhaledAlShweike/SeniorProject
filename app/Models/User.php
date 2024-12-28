<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // Specify the table name if different from the pluralized model name

    protected $fillable = [
        'TenantID',
        'User Name',
        'Email',
        'Password',
        'Role',
    ];

    /**
     * Get the tenant that owns the user.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'TenantID', 'TenantID');
    }

    /**
     * Get the queries for the user.
     */
    public function queries()
    {
        return $this->hasMany(Query::class, 'User ID', 'User ID');
    }

    /**
     * Get the patient records for the user if the user is a doctor.
     */
    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'DoctorID', 'User ID')->where('Role', 'Doctor');
    }
}
