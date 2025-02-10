<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyPart extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function images() {
        return $this->belongsToMany(Image::class, 'body_part_images')->withTimestamps();
    }
}
