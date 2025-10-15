<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudadano;
use Carbon\Carbon;

class CiudadanosTableSeeder extends Seeder
{
    public function run()
    {
        $ciudadanos = [
            [
                'primer_nombre' => 'Juan',
                'segundo_nombre' => 'Carlos',
                'primer_apellido' => 'Pérez',
                'segundo_apellido' => 'González',
                'fecha_nacimiento' => Carbon::parse('1985-07-15'),
                'sexo' => 'M',
                'cedula' => '28712893',
                'nacionalidad' => 'Venezolana',
            ],
            [
                'primer_nombre' => 'María',
                'segundo_nombre' => 'Fernanda',
                'primer_apellido' => 'Rodríguez',
                'segundo_apellido' => 'López',
                'fecha_nacimiento' => Carbon::parse('1990-11-25'),
                'sexo' => 'F',
                'cedula' => '28454282',
                'nacionalidad' => 'Venezolana',
            ],
            [
                'primer_nombre' => 'Victor',
                'segundo_nombre' => 'Fernanda',
                'primer_apellido' => 'Aparicio',
                'segundo_apellido' => 'López',
                'fecha_nacimiento' => Carbon::parse('1990-11-25'),
                'sexo' => 'M',
                'cedula' => '30349343',
                'nacionalidad' => 'Venezolana',
            ],
            // Agrega más ejemplos según necesites
        ];

        foreach ($ciudadanos as $ciudadano) {
            Ciudadano::create($ciudadano);
        }
    }
}
