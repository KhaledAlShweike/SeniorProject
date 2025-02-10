<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = [
        'date',
        'url',
        'is_private',
        'uploaded_by_patient',
        'type_id',       // Foreign key for Type
        'body_part_id',  // Foreign key for BodyPart
        'case_id'        // Foreign key for Case
    ];

    public function Case()
    {
        return $this->belongsTo(Cases::class); //
    }


    public function bodyParts() {
        return $this->belongsToMany(BodyPart::class, 'body_part_images')->withTimestamps();
    }

    public function Type()
    {
        return $this->belongsTo(ImageType::class);
    }
}
