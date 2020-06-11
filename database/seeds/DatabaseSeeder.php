<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(EventTypesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsAndServicesTableSeeder::class);
        $this->call(BudgetsTableSeeder::class);
    }
}
