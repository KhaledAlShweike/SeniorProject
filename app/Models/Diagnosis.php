<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['condition_id', 'symptom_id', 'present', 'last_updated'];

    public function Condition()
    {
        return $this->belongsTo(Condition::class); //
    }


    public function Case()
    {
        return $this->belongsTo(Cases::class); //
    }
}
