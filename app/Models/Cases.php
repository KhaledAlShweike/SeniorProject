<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $table = 'cases';

    protected $fillable = [
        'specialist_id',
        'patient_id',
        'isPrivate',
        'date',
        'notes',
        'treatment_plan',
    ];

    public function Specialist()
    {
        return $this->belongsTo(Specialist::class); //
    }

    public function Patient()
    {
        return $this->belongsTo(Patient::class); //
    }

    public function Diagnosis()
    {
        return $this->hasMany(Diagnosis::class); //
    }

    public function CaseSymptom()
    {
        return $this->hasOne(CaseSymptom::class); //
    }

    public function Image()
    {
        return $this->hasMany(Image::class); //
    }
}
