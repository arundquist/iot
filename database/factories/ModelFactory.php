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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'admin' => true,
    ];
});

$factory->defineAs(App\User::class, 'approved', function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
        'approved' => true,
    ];
});

$factory->define(App\Measurement::class, function (Faker\Generator $faker){
    return [
        'machine_id' => $faker->unique()->randomNumber(5),
        'probe_id' => $faker->unique()->randomNumber(5),
        'location_id' => $faker->unique()->randomNumber(5),
        'measurement' => $faker->randomFloat(3, 0, 100),
    ];
});

$factory->define(App\Machine::class, function (Faker\Generator $faker){
    return [
        'macaddress' => $faker->randomNumber(8)
    ];
});

$factory->define(App\Probe::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->text(12),
        'description' => $faker->paragraph(3),
        'type' => $faker->text(6),
        'units' => $faker->text(6)
    ];
});



$factory->define(App\Location::class, function (Faker\Generator $faker){
    return [
        'shortname' => $faker->text(12),
        'description' => $faker->paragraph(3),
        'gps' => $faker->text(),
    ];
});

$factory->define(App\Code::class, function (Faker\Generator $faker){
    return [
        'machine_id' => $faker->unique()->randomNumber(5),
        'user_id' => $faker->unique()->randomNumber(5),
        'code' => $faker->paragraph(10),
    ];
});
