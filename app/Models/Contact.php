<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $connection = 'ehr';

    protected $fillable = ['type', 'value', 'user_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
