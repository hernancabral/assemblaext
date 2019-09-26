<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'nro' => $faker->unique(true)->numberBetween(1, 1000),
        'space_id' => $faker->unique(true)->numberBetween(1, 1000),
        'title' => $faker->unique()->title,
        'code' => $faker->unique()->title,
        'status' => 'OK',
        'work_remaining' => $faker->numberBetween($min = 1, $max = 15),
        'worked_hours' => $faker->numberBetween($min = 1, $max = 15),
        'estimate' => '40',
        'original_estimate' => '30',
        'production_date' => $faker->dateTimeThisMonth($max = 'now', $timezone = null),
    ];
});
