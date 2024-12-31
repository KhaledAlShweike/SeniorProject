<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    public function cases()
    {
        return $this->hasMany(Cases::class, 'SymptomID');
    }
}
