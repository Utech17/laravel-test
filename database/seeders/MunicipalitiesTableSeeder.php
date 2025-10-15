<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipality;
use App\Models\State;

class MunicipalitiesTableSeeder extends Seeder
{
    public function run()
    {
        $municipalitiesByState = [
            'Amazonas' => [
                'Alto Orinoco', 'Atabapo', 'Atures', 'Autana', 'Manapiare', 'Maroa', 'Río Negro'
            ],
            'Anzoátegui' => [
                'Anaco', 'Aragua', 'Bolívar', 'Bruzual', 'Cajigal', 'Carvajal', 'Diego Bautista Urbaneja', 'Freites', 'Guanipa',
                'Guanta', 'Independencia', 'Libertad', 'McGregor', 'Miranda', 'Monagas', 'Peñalver', 'Píritu',
                'San Juan de Capistrano', 'Santa Ana', 'Simón Bolívar', 'Simón Rodríguez', 'Sotillo'
            ],
            'Apure' => [
                'Achaguas', 'Biruaca', 'Muñoz', 'Páez', 'Pedro Camejo', 'Rómulo Gallegos', 'San Fernando'
            ],
            'Aragua' => [
                'Bolívar', 'Camatagua', 'Francisco Linares Alcántara', 'Girardot', 'José Ángel Lamas',
                'José Félix Ribas', 'José Rafael Revenga', 'Libertador', 'Mario Briceño Iragorry',
                'Ocumare de la Costa de Oro', 'San Casimiro', 'San Sebastián', 'Santiago Mariño',
                'Santos Michelena', 'Sucre', 'Tovar', 'Urdaneta', 'Zamora'
            ],
            'Barinas' => [
                'Alberto Arvelo Torrealba', 'Andrés Eloy Blanco', 'Antonio José de Sucre', 'Arismendi', 'Barinas',
                'Bolívar', 'Cruz Paredes', 'Ezequiel Zamora', 'Obispos', 'Pedraza', 'Rojas', 'Sosa'
            ],
            'Bolívar' => [
                'Angostura', 'Caroní', 'Cedeño', 'El Callao', 'Gran Sabana', 'Heres', 'Padre Pedro Chien',
                'Piar', 'Roscio', 'Sifontes', 'Sucre'
            ],
            'Carabobo' => [
                'Bejuma', 'Carlos Arvelo', 'Diego Ibarra', 'Guacara', 'Juan José Mora', 'Libertador',
                'Los Guayos', 'Miranda', 'Montalbán', 'Naguanagua', 'Puerto Cabello', 'San Diego',
                'San Joaquín', 'Valencia'
            ],
            'Cojedes' => [
                'Anzoátegui', 'Falcón', 'Girardot', 'Lima Blanco', 'Pao de San Juan Bautista', 'Ricaurte',
                'Rómulo Gallegos', 'San Carlos', 'Tinaco'
            ],
            'Delta Amacuro' => [
                'Antonio Díaz', 'Casacoima', 'Pedernales', 'Tucupita'
            ],
            'Distrito Capital' => [
                'Libertador'
            ],
            'Falcón' => [
                'Acosta', 'Bolívar', 'Buchivacoa', 'Cacique Manaure', 'Carirubana', 'Colina', 'Dabajuro',
                'Democracia', 'Falcón', 'Federación', 'Jacura', 'Los Taques', 'Mauroa', 'Miranda', 'Monseñor Iturriza',
                'Palma Sola', 'Petit', 'Píritu', 'San Francisco', 'Silva', 'Sucre', 'Tocópero', 'Unión', 'Urumaco', 'Zamora'
            ],
            'Guárico' => [
                'Camaguán', 'Chaguaramas', 'El Socorro', 'Francisco de Miranda', 'José Félix Ribas',
                'José Tadeo Monagas', 'Juan Germán Roscio', 'Julián Mellado', 'Las Mercedes',
                'Leonardo Infante', 'Ortiz', 'Pedro Zaraza', 'San Gerónimo de Guayabal', 'San José de Guaribe',
                'Santa María de Ipire'
            ],
            'La Guaira' => [
                'Vargas'
            ],
            'Lara' => [
                'Andrés Eloy Blanco', 'Crespo', 'Iribarren', 'Jiménez', 'Morán', 'Palavecino',
                'Simón Planas', 'Torres', 'Urdaneta'
            ],
            'Mérida' => [
                'Alberto Adriani', 'Andrés Bello', 'Antonio Pinto Salinas', 'Aricagua', 'Arzobispo Chacón',
                'Campo Elías', 'Caracciolo Parra Olmedo', 'Cardenal Quintero', 'Guaraque', 'Julio César Salas',
                'Justo Briceño', 'Libertador', 'Miranda', 'Obispo Ramos de Lora', 'Padre Noguera', 'Pueblo Llano',
                'Rangel', 'Rivas Dávila', 'Santos Marquina', 'Sucre', 'Tovar', 'Tulio Febres Cordero', 'Zea'
            ],
            'Miranda' => [
                'Acevedo', 'Andrés Bello', 'Baruta', 'Brión', 'Buroz', 'Carrizal', 'Chacao', 'Cristóbal Rojas',
                'El Hatillo', 'Guaicaipuro', 'Independencia', 'Lander', 'Los Salias', 'Páez', 'Paz Castillo',
                'Pedro Gual', 'Plaza', 'Simón Bolívar', 'Sucre', 'Urdaneta', 'Zamora'
            ],
            'Monagas' => [
                'Acosta', 'Aguasay', 'Bolívar', 'Caripe', 'Cedeño', 'Ezequiel Zamora', 'Libertador',
                'Maturín', 'Piar', 'Punceres', 'Santa Bárbara', 'Sotillo', 'Uracoa'
            ],
            'Nueva Esparta' => [
                'Antolín del Campo', 'Arismendi', 'Díaz', 'García', 'Gómez', 'Maneiro', 'Marcano', 'Mariño',
                'Península de Macanao', 'Tubores', 'Villalba'
            ],
            'Portuguesa' => [
                'Agua Blanca', 'Araure', 'Esteller', 'Guanare', 'Guanarito', 'Monseñor José Vicente de Unda',
                'Ospino', 'Páez', 'Papelón', 'San Genaro de Boconoíto', 'San Rafael de Onoto', 'Santa Rosalía',
                'Sucre', 'Turén'
            ],
            'Sucre' => [
                'Andrés Eloy Blanco', 'Andrés Mata', 'Arismendi', 'Benítez', 'Bermúdez', 'Bolívar', 'Cajigal',
                'Cruz Salmerón Acosta', 'Libertador', 'Mariño', 'Mejía', 'Montes', 'Ribero', 'Sucre', 'Valdez'
            ],
            'Táchira' => [
                'Andrés Bello', 'Antonio Rómulo Costa', 'Ayacucho', 'Bolívar', 'Cárdenas', 'Córdoba', 'Fernández Feo',
                'Francisco de Miranda', 'García de Hevia', 'Guásimos', 'Independencia', 'Jáuregui', 'José María Vargas',
                'Junín', 'Libertad', 'Libertador', 'Lobatera', 'Michelena', 'Panamericano', 'Pedro María Ureña',
                'Rafael Urdaneta', 'Samuel Darío Maldonado', 'San Cristóbal', 'San Judas Tadeo', 'Seboruco',
                'Simón Rodríguez', 'Sucre', 'Torbes', 'Uribante'
            ],
            'Trujillo' => [
                'Andrés Bello', 'Boconó', 'Bolívar', 'Candelaria', 'Carache', 'Escuque', 'José Felipe Márquez Cañizales',
                'Juan Vicente Campo Elías', 'La Ceiba', 'Miranda', 'Monte Carmelo', 'Motatán', 'Pampán',
                'Pampanito', 'Rafael Rangel', 'San Rafael de Carvajal', 'Sucre', 'Trujillo', 'Urdaneta', 'Valera'
            ],
            'Yaracuy' => [
                'Arístides Bastidas', 'Bolívar', 'Bruzual', 'Cocorote', 'Independencia', 'José Antonio Páez',
                'La Trinidad', 'Manuel Monge', 'Nirgua', 'Peña', 'San Felipe', 'Sucre', 'Urachiche', 'Veroes'
            ],
            'Zulia' => [
                'Almirante Padilla', 'Baralt', 'Cabimas', 'Catatumbo', 'Colón', 'Francisco Javier Pulgar', 'Guajira',
                'Jesús Enrique Lossada', 'Jesús María Semprún', 'La Cañada de Urdaneta', 'Lagunillas', 'Machiques de Perijá',
                'Mara', 'Maracaibo', 'Miranda', 'Rosario de Perijá', 'San Francisco', 'Santa Rita', 'Simón Bolívar', 'Sucre',
                'Valmore Rodríguez'
            ]
        ];

        foreach ($municipalitiesByState as $stateName => $municipalities) {
            $state = State::where('name', $stateName)->first();

            if ($state) {
                foreach ($municipalities as $municipality) {
                    Municipality::create([
                        'state_id' => $state->id,
                        'name' => $municipality,
                    ]);
                }
            }
        }
    }
}
