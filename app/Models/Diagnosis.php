<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['condition_id', 'symptom_id', 'present', 'last_updated'];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }
}
