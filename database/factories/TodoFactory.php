<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'start' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'end' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'type' => $faker->randomElement($array = array('individual','collaborative')),
        'is_done' => $faker->randomElement($array = array(0,1))
    ];
});
