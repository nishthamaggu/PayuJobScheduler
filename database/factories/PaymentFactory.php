<?php

use Illuminate\Support\Str;
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

$factory->define(App\Payment::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomNumber,
        'payment_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'txn_id' => $faker->unique()->asciify('**********'),
        'bank_name' => $faker->name,
        'pay_mode' => $faker->randomElement(['cash', 'wallet', 'upi', 'card']),
        'status' => $faker->numberBetween($min = 0, $max = 1), 
    ];
});