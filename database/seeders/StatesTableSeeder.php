<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = [
            'Amazonas', 'Anzoátegui', 'Apure', 'Aragua', 'Barinas', 'Bolívar',
            'Carabobo', 'Cojedes', 'Delta Amacuro', 'Distrito Capital', 'Falcón',
            'Guárico', 'La Guaira', 'Lara', 'Mérida', 'Miranda', 'Monagas',
            'Nueva Esparta', 'Portuguesa', 'Sucre', 'Táchira', 'Trujillo',
            'Yaracuy', 'Zulia'
        ];
        foreach ($states as $state) {
            State::create(['name' => $state]);
        }
    }
}
