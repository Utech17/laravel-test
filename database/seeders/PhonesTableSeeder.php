<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phone;
use App\Models\User;

class PhonesTableSeeder extends Seeder
{
    public function run()
    {
        // Supón que hay usuarios existentes con id 1 y 2
        $phones = [
            [
                'user_id' => 1,
                'prefix' => '412',
                'number' => '1234567',
            ],
            [
                'user_id' => 2,
                'prefix' => '414',
                'number' => '7654321',
            ],
            [
                'user_id' => 3,
                'prefix' => '424',
                'number' => '5551234',
            ],
        ];

        foreach ($phones as $phone) {
            Phone::create($phone);
        }
    }
}
