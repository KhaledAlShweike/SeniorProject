<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    public function cases()
    {
        return $this->hasMany(Cases::class, 'DiseaseID');
    }
}
