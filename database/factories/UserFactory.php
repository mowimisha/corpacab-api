<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\User;
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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'middlename' => $faker->name,
        'lastname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
        'status' => $faker->randomElement([0, 1]),
        'phone' => $faker->unique()->phoneNumber,
        'role' => $faker->randomElement(['dev', 'admin', 'owner', 'driver']),
        'driver_license' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'good_conduct' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'profile_picture' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'psv' => $faker->imageUrl($width = 150, $height = 150, 'cats'),
        'national_id' => $faker->unique()->randomNumber(7, false),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
