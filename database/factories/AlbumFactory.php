<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'transition_in' => 1,
        'transition_out' => 2,
        'transition' => 6,
        'type' => 'sub_banner'
    ];
});
