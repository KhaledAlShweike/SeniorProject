<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryImage extends Model
{
    use HasFactory;
    protected $fillable = ['query_id'];

    public function queries()
    {
        return $this->belongsTo(Query::class);
    }
}
