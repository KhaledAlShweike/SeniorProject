<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'notes', 'default_case_privacy', 'institution_id'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'case_symptoms');
    }
}
