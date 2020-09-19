<?php

namespace Database\Seeders;

use App\Models\SchoolSector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        SchoolSector::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        SchoolSector::flushEventListeners();

        $sectors = [['name' => 'Pública'], ['name' => 'Privada'], ['name' => 'Autogestión']];
        DB::table('school_sectors')->insert($sectors);
    }
}
