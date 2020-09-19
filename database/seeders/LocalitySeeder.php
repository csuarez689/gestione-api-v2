<?php

namespace Database\Seeders;

use App\Models\Locality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        Locality::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        Locality::flushEventListeners();

        $path = 'database/scripts/localities.sql';
        DB::unprepared(file_get_contents($path));
    }
}
