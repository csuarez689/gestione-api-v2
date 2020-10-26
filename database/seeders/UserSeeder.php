<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //vacia la tabla
        User::truncate();

        //desabilita los event listener durante el relleno de la base de datos
        User::flushEventListeners();

        //seed one admin user
        $adminUser = [
            'name' => 'Claudio',
            'last_name' => 'Suarez',
            'dni' => '34608026',
            'email' => 'csuarez689@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin20'),
            'phone' => '2664774140',
            'isAdmin' => User::ADMIN_USER,
        ];

        DB::table('users')->insert([$adminUser]);

        //seed regular user using factory
        User::factory()->times(20)->create();
    }
}
