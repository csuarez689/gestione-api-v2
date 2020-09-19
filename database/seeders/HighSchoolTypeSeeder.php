<?php

namespace Database\Seeders;

use App\Models\HighSchoolType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighSchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        HighSchoolType::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        HighSchoolType::flushEventListeners();

        $high_school_types = [
            ['name' => 'EGB'],
            ['name' => 'CB'],
            ['name' => 'CO'],
            ['name' => 'CBCO'],
            ['name' => 'Otros']
        ];
        DB::table('high_school_types')->insert($high_school_types);
    }
}
