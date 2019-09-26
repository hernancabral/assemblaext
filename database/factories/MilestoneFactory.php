<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Milestone;
use Faker\Generator as Faker;

$factory->define(Milestone::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => Str::random(5),
        'monitor' => $faker->boolean(50),
    ];
});
