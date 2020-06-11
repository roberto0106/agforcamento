<?php

use Illuminate\Database\Seeder;

class ProductsAndServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ProductAndService::class, 30)->create();

    }
}
