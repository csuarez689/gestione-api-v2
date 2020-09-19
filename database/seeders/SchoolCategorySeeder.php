<?php

namespace Database\Seeders;

use App\Models\SchoolCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        SchoolCategory::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        SchoolCategory::flushEventListeners();

        $school_categories = [
            ['name' => '1'],
            ['name' => '2'],
            ['name' => '3'],
            ['name' => 'PU']
        ];
        DB::table('school_categories')->insert($school_categories);
    }
}
