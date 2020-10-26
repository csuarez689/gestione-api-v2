<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        Teacher::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        Teacher::flushEventListeners();

        //seed regular user using factory
        Teacher::factory()->times(20)->create();
    }
}
