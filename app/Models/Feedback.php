<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public function Institution()
    {
        return $this->belongsTo(Institution::class, 'TenantID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
