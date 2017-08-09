<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'category' => 'category'. rand(1,2)
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {
   return [
       'category_id' => rand(1,2),
//       'barcode' => rand(10000000, 9999999),
       'product' => 'Product ' . rand(1,10),
       'price' => rand(1, 300) . '000'
   ];
});
