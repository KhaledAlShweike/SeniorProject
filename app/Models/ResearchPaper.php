<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchPaper extends Model
{
    use HasFactory;
    protected $connection = 'mir';


    protected $fillable = [
        'pmc_id',
        'title',
        'abstract',
        'url',
        'publication_year'
    ];
}
