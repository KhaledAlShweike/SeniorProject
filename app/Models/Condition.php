<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['name', 'probability'];

    public function Diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }
}
