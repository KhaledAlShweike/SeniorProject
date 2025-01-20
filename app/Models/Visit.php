<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    protected $table = 'visits';

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
