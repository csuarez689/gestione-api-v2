<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        Province::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        Province::flushEventListeners();

        $path = 'database/scripts/provinces.sql';
        DB::unprepared(file_get_contents($path));
    }
}
