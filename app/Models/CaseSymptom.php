<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseSymptom extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['case_id', 'symptom_id'];

    public function case()
    {
        return $this->belongsTo(Cases::class);
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
