<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CivilStatus;

class CivilStatusesTableSeeder extends Seeder
{
    public function run()
    {
        $civilStatuses = [
            'Soltero(a)',
            'Casado(a)',
            'Divorciado(a)',
            'Viudo(a)',
            'Unión Libre',
            'Separado(a)',
        ];

        foreach ($civilStatuses as $status) {
            CivilStatus::create(['name' => $status]);
        }
    }
}
