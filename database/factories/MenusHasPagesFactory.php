<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\MenusHasPages;
use Faker\Generator as Faker;

$factory->define(MenusHasPages::class, function (Faker $faker) {
    return [
        'parent_pages_id' => 0,
        'pages_id' => factory(Page::class)->create()->id,
        'pages_order' => 1,
        'uri' => ''
    ];
});
