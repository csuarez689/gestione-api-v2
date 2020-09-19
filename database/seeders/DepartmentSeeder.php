<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        Department::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        Department::flushEventListeners();

        $path = 'database/scripts/departments.sql';
        DB::unprepared(file_get_contents($path));
    }
}
