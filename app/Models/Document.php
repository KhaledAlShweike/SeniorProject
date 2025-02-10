<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
use HasFactory;

protected $connection = 'ehr';

    protected $fillable = ['url', 'user_id'];

    public function Specialist()
    {
        return $this->belongsTo(Specialist::class);
    }
}
