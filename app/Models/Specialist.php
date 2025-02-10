<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'degree',
        'specialization',
        'bio',
        'certified',
        'institution_id'
    ];

    public function Institution()
    {
        return $this->belongsToMany(Institution::class);
    }

    public function Cases()
    {
        return $this->hasMany(Cases::class, 'specialist_id');
    }

    public function MedicalRecord()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function Document()
    {
        return $this->hasMany(Document::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
