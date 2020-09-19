<?php

namespace Database\Seeders;

use App\Models\SchoolAmbit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolAmbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        SchoolAmbit::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        SchoolAmbit::flushEventListeners();

        $ambits = [['name' => 'Común'], ['name' => 'Rural']];
        DB::table('school_ambits')->insert($ambits);
    }
}
