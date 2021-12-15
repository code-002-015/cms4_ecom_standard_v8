<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Menu;
use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'is_active' => 0,
        'pages_json' => '[]'
    ];
});
