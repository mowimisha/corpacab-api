<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        //
        'vehicle_registration' => 'K' . $faker->randomElement(['B', 'C']) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']) . $faker->numberBetween($min = 100, $max = 999) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']),
        'service_date' => Carbon::now(),
        'current_odometer_reading' => $faker->randomNumber(6, false),
        'kms_serviced' => $faker->randomNumber(4, false),
        'next_kms_service' => $faker->randomNumber(6, false),
        'status' => $faker->randomElement(['0', '1', '2']),
        'battery_status' => $faker->randomElement(['0', '1', '2']),
        'reminder_date' => Carbon::now(),
    ];
});
