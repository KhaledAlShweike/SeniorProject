<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'is_private', 'body_part', 'uploaded_by_patient'];

    public function case()
    {
        return $this->belongsTo(Cases::class);
    }
}
