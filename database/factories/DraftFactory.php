<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Draft;
use Faker\Generator as Faker;

$factory->define(Draft::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'heading' => $faker->catchPhrase,
        'body' => $faker->paragraph(3),
        'owner_id' => factory(App\User::class),
    ];
});
