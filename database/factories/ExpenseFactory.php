<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Carbon\Carbon;
use App\Models\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'car_registration' => 'K' . $faker->randomElement(['B', 'C']) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']) . $faker->numberBetween($min = 100, $max = 999) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']),

        'expense' => $faker->randomElement(['Body work', 'Insurance', 'Wheels', 'Side Mirror', 'Wind-Screen']),
        'amount' => $faker->randomNumber(4, false),
        'receipts' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
