<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Administrador",
            'email' => "tecnologia@agenciapni.com.br",
            'level' => 9,
            'password' => Hash::make('Oel228073'), // secret
            'remember_token' => str_random(10),
        ]);
        factory(\App\User::class, 2)->create();
    }
}
