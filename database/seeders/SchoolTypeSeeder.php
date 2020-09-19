<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        SchoolType::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        SchoolType::flushEventListeners();

        $school_types = [
            ['name' => 'Común'],
            ['name' => 'Adultos'],
            ['name' => 'Autogestionada'],
            ['name' => 'Técnica'],
            ['name' => 'Pública Digital'],
            ['name' => 'Generativa']
        ];
        DB::table('school_types')->insert($school_types);
    }
}
