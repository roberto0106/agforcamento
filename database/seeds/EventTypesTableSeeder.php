<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now(new DateTimeZone('America/Sao_Paulo'));
        DB::table('event_types')->insert([
            'name' => 'Formatura',
            'status' => 1,
            'position' => 1,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'Colação de Grau',
            'status' => 1,
            'position' => 2,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'Jantar',
            'status' => 1,
            'position' => 3,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'Pré Evento',
            'status' => 1,
            'position' => 4,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'Churrasco',
            'status' => 1,
            'position' => 5,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'Culto Ecomenico',
            'status' => 1,
            'position' => 6,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'After',
            'status' => 1,
            'position' => 7,
            'created_at' => $date
        ]);

        DB::table('event_types')->insert([
            'name' => 'Festa do Meio Médico',
            'status' => 1,
            'position' => 8,
            'created_at' => $date
        ]);
    }
}
