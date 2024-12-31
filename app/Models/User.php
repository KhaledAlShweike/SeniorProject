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

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'TenantID');
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class, 'UserID');
    }

    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'UserID');
    }
}
