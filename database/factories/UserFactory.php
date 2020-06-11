<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'level' => 1,
        'password' => Hash::make('leo228073'), // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Course::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'status' => 1,
    ];
});

$factory->define(App\Models\Client::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->word,
        'institution' => ucwords(implode(" ", $faker->words(3, false))),
        'courses' => ucwords(implode(" ", $faker->words(2, false))),
        'month_conclusion' => $faker->randomKey(['7' => '7', '12' => '12']),
        'year_conclusion' => $faker->randomKey(['2019' => '2019', '2020' => '2020', '2021' => '2021', '2022' => '2022'])
    ];
});

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'event_type_id' => rand(1,2),
        'name' => ucwords(implode(" ", $faker->words(3, false))),
        'status' => '1',
        'position' => rand(1,10),
    ];
});

$factory->define(App\Models\ProductAndService::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'category_id' => rand(1,3),
        'price' => $faker->randomFloat(2, 1000, 24000),
        'cost_price' => $faker->randomFloat(2, 900, 3000),
        'minimum_price' => $faker->randomFloat(2, 30, 24000),
        'description' => $faker->sentence(16),
        'position' => rand(1,5),
        'proportion_per_person' => 0,
        'multiplied_invitations' => 0,
        'multiplying_graduates' => 0,
        'extras_invitations' => 0,
        'extras_tables' => 0,
        'alias' => 0,
    ];
});

$factory->define(App\Models\Budget::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'client_id' => rand(1,5),
        'number_of_installments' => rand(10, 15),
        'fee' => $faker->randomFloat(2, 8, 15),
        'photo_exclusivity' => $faker->randomFloat(2, 20000, 30000),
        'shelf_life' => $faker->date("Y-m-d", '2018-04-30'),
        'internal_comment' => $faker->sentence(2),
        'external_comment' => $faker->sentence(1),
        'status' => 1,
    ];
});