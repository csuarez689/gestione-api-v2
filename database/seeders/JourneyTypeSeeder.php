<?php

namespace Database\Seeders;

use App\Models\JourneyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JourneyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        JourneyType::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        JourneyType::flushEventListeners();

        $journey_types = [['name' => 'Simple'], ['name' => 'Completa']];
        DB::table('journey_types')->insert($journey_types);
    }
}
