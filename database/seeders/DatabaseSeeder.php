<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //desabilita las restruicciones de claves foraneas
        Schema::disableForeignKeyConstraints();

        //Seeders
        $this->call([
            UserSeeder::class,
            SchoolSectorSeeder::class,
            SchoolAmbitSeeder::class,
            SchoolTypeSeeder::class,
            JobStateSeeder::class,
            SchoolLevelSeeder::class,
            HighSchoolTypeSeeder::class
        ]);

        //habilita restricciones de claves foraneas
        Schema::enableForeignKeyConstraints();
    }
}
