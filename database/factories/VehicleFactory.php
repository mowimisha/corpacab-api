<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vehicle;
use Faker\Generator as Faker;

$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'driver_id' => function () use ($faker) {
            if (User::count() > 0) {
                return $faker->randomElement(User::pluck('id')->toArray());
            } else return factory(User::class)->create()->id;
        },

        'owner_id' => function () use ($faker) {
            if (User::count() > 0) {
                return $faker->randomElement(User::pluck('id')->toArray());
            } else return factory(User::class)->create()->id;
        },

        'vehicle_image' => $faker->imageUrl($width = 150, $height = 150, 'cats'),

        'registration_no' => 'K' . $faker->randomElement(['B', 'C']) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']) . $faker->numberBetween($min = 100, $max = 999) . $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']),

        'make' => $faker->randomElement(['Toyota', 'Toyota', 'Toyota']),
        'model' => $faker->randomElement(['Vitz', 'Platz', 'Passso', 'Fielder', 'March']),
        'yom' => $faker->randomElement(['2005', '2006', '2007', '2008', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018']),
        'color' => $faker->randomElement(['Black', 'White', 'Red', 'Blue', 'Silver', 'Grey']),
        'fuel_type' => $faker->randomElement(['Diesel', 'Petrol', 'Hybrid']),
        'status' => $faker->randomElement([0, 1]),
        'logbook' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'insurance_sticker' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'uber_inspection' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'psv' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'ntsa_inspection' => $faker->imageUrl($width = 150, $height = 150, 'cats'),

    ];
});
