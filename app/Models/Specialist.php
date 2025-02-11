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

  

    public function Document()
    {
        return $this->hasMany(Document::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Specialisttype()
    {
        return $this->belongsTo(SpecialistType::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
