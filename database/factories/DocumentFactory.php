<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\User;
use App\Models\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'document_type' => $faker->randomElement(['driver_license', 'good_conduct', 'psv', 'insurance_sticker', 'uber_inspection', 'ntsa_inspection']),

        'document_owner' => function () use ($faker) {
            if (User::count() > 0) {
                return $faker->randomElement(User::pluck('id')->toArray());
            } else return factory(User::class)->create()->id;
        },

        'car' => 'K' . $faker->randomElement(['B', 'C']) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']) . $faker->numberBetween($min = 100, $max = 999) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']),

        'issue_date' => Carbon::now(),
        'expiry_date' => Carbon::now(),
        'reminder_date' => Carbon::now(),
        'status' => $faker->randomElement(['0', '1', '2']),

    ];
});
