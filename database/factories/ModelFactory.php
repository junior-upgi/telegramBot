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
/*
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

*/

$factory->define(App\Models\telegram\Bot::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'token' => $faker->word,
        'updateID' => $faker->word,
    ];
});

$factory->define(App\Models\upgiSystem\User::class, function (Faker\Generator $faker) {
    return [
        'ID' => $faker->word,
        'mobileSystemAccount' => $faker->word,
        'telegramID' => $faker->word,
    ];
});
