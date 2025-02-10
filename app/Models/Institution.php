<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['name', 'address'];

    public function Specialists()
    {
        return $this->hasMany(Specialist::class); //
    }


}
