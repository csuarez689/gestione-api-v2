<?php

namespace Database\Seeders;

use App\Models\JobState;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        JobState::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        JobState::flushEventListeners();

        $job_states = [
            ['name' => 'Titular'],
            ['name' => 'Interino'],
            ['name' => 'Suplente'],
            ['name' => 'Licencia']
        ];
        DB::table('job_states')->insert($job_states);
    }
}
