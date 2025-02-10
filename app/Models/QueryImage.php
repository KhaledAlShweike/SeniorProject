<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryImage extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = ['query_id'];

    public function Queries()
    {
        return $this->belongsTo(Query::class); //
    }
}
