<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Expenditure;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Expenditure::class, function (Faker $faker) {
    return [
        'paid_to' => $faker->name,
        'expenditure' => $faker->name,
        'amount' => $faker->randomNumber(4, false),
        'receipts' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
