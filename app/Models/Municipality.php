<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;

class Municipality extends Model
{
    protected $fillable = ['state_id', 'name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
