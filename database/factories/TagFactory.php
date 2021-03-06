<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tag;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => Str::random(5),
    ];
});
