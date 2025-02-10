<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function specialists()
    {
        return $this->hasMany(Specialist::class);
    }
}
