<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\Commune;

class Address extends Model
{
    protected $fillable = [
        'commune_id',
        'urbanizacion',
        'calle',
        'numero_casa',
        'otro',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}
