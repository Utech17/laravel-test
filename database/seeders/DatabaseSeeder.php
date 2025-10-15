<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(3)->create([
            'name' => 'Test User',
            'password' => 'password123',
        ]);
        $this->call(StatesTableSeeder::class);
        $this->call(MunicipalitiesTableSeeder::class);
        $this->call(ParishesTableSeeder::class);
        $this->call(CommunesTableSeeder::class);
        $this->call(OccupationsTableSeeder::class);
        $this->call(CivilStatusesTableSeeder::class);
        $this->call(CiudadanosTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(PhonesTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
    }
}
