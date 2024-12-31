<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentRecommendation extends Model
{
    public function Institution()
    {
        return $this->belongsTo(Institution::class, 'TenantID');
    }

    public function Queries()
    {
        return $this->belongsTo(Queries::class, 'QueryID');
    }
}
