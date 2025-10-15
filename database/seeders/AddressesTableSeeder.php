<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\State;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\Commune;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        $commune = Commune::where('name', 'Comuna Kilómetro 88')->first();

        Address::create([
            'commune_id' => $commune?->id,
            'urbanizacion' => 'El Paraíso',
            'calle' => 'Calle 5',
            'numero_casa' => 'A-123',
            'otro' => 'Edificio América',
        ]);

        // Agrega más direcciones según necesidad
    }
}
