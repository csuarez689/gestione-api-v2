<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        SchoolLevel::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        SchoolLevel::flushEventListeners();

        $school_levels = [
            ['name' => 'Inicial'],
            ['name' => 'Primario'],
            ['name' => 'Secundario']
        ];
        DB::table('school_levels')->insert($school_levels);
    }
}
