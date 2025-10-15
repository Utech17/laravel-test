<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;
use App\Models\Occupation;
use App\Models\CivilStatus;
use App\Models\Ciudadano;
use App\Models\Phone;
use App\Models\Address;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        // Ejemplo para usuarios ya existentes
        $user = User::first();
        $occupation = Occupation::first();
        $civilStatus = CivilStatus::first();
        $ciudadano = Ciudadano::first();
        $phone = Phone::first();
        $address = Address::first();

        if ($user) {
            Profile::create([
                'user_id' => $user->id,
                'occupation_id' => $occupation?->id,
                'civil_status_id' => $civilStatus?->id,
                'ciudadano_id' => $ciudadano?->id,
                'phone_id' => $phone?->id,
                'address_id' => $address?->id,
            ]);
        }
    }
}
