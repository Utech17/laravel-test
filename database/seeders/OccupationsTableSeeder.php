<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Occupation;

class OccupationsTableSeeder extends Seeder
{
    public function run()
    {
        $occupations = [
            'Ingeniero',
            'Profesor',
            'Médico',
            'Abogado',
            'Contador',
            'Agricultor',
            'Comerciante',
            'Chofer',
            'Obrero',
            'Estudiante',
            'Funcionario Público',
            'Técnico',
            'Artista',
            'Desarrollador de Software',
            'Enfermero',
            'Arquitecto',
            'Psicólogo',
            'Periodista',
            'Veterinario',
            'Cocinero'
        ];

        foreach ($occupations as $occupation) {
            Occupation::create(['name' => $occupation]);
        }
    }
}
