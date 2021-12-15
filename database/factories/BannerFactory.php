<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Banner;
use Faker\Generator as Faker;

$factory->define(Banner::class, function (Faker $faker) {
    return [
        'album_id' => factory(App\Album::class)->create()->id,
        'title' => $faker->name(),
        'description' => $faker->paragraph(),
        'image_path' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
        'url' => url('/'),
        'alt' => $faker->name()
    ];
});
