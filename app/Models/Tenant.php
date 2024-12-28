<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';


    protected $fillable = [
        'TenantName',
        'Address',
        'ContactDetails'
    ];

    /**
     * Get the users for the tenant.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'TenantID', 'TenantID');
    }

    /**
     * Get the patient records for the tenant.
     */
    public function patientRecords()
    {
        return $this->hasMany(PatientRecord::class, 'TenantID', 'TenantID');
    }

    /**
     * Get the queries for the tenant.
     */
    public function queries()
    {
        return $this->hasMany(Query::class, 'TenantID', 'TenantID');
    }
}
