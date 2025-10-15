<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Phone extends Model
{
    protected $fillable = [
        'user_id',
        'prefix',
        'number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
