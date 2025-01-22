<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $connection = 'ehr';


    protected $fillable = [
        'date',
        'note',
        'case_id',
    ];
    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }
}
