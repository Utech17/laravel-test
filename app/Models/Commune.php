<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parish;

class Commune extends Model
{
    protected $fillable = ['parish_id', 'name'];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}
