<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Administrador',
            'email' => 'contato@leandroparice.com.br',
            'password' => bcrypt('123456'),
            'type' => 'superadmin',
            'status' => true,
        ]);
    }
}
