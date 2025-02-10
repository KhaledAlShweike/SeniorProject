<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
    protected $connection = 'ehr';

    protected $fillable = ['time', 'text', 'user_id'];

    public function User()
    {
        return $this->belongsTo(User::class); //
    }

    public function QueryImage()
    {
        return $this->hasMany(QueryImage::class); //
    }


}
