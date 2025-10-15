<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Occupation;
use App\Models\CivilStatus;
use App\Models\Ciudadano;
use App\Models\Phone;
use App\Models\Address;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'occupation_id',
        'civil_status_id',
        'ciudadano_id',
        'phone_id',
        'address_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function civilStatus()
    {
        return $this->belongsTo(CivilStatus::class);
    }

    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class);
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
