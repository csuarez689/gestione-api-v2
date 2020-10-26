<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        // School::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        School::flushEventListeners();

        //seed regular user using factory
        School::factory()->times(20)->create();
    }
}
