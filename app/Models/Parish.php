<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Municipality;
use App\Models\Commune;

class Parish extends Model
{
    protected $fillable = ['municipality_id', 'name'];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
