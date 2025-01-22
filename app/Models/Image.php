<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['date', 'is_private', 'body_part', 'uploaded_by_patient', 'case_id'];

    protected $fillable = ['date', 'is_private', 'body_part', 'uploaded_by_patient'];
>>>>>>> 52a848b5c48361ffc2ba360faf77dba6afd1a14f

    public function case()
    {
        return $this->belongsTo(Cases::class);
    }
}
