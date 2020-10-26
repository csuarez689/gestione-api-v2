<?php

namespace Database\Seeders;

use App\Models\TeachingPlant;
use Illuminate\Database\Seeder;

class TeachingPlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        TeachingPlant::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        TeachingPlant::flushEventListeners();

        //seed regular user using factory
        TeachingPlant::factory()->times(200)->create();
    }
}
