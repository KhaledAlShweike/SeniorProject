<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{

    public function Institution()
    {
        return $this->belongsTo(Institution::class); //
    }
}
