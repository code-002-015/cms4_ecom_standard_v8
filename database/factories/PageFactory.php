<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'parent_pages_id' => 0,
        'albums_id' => factory(Album::class)->create()->id,
        'slug' => $faker->title(),
        'name' => $faker->title(),
        'label' =>'',
        'contents' => $faker->paragraph(),
        'status' => 'publish',
        'page_type' => 'custom',
        'image_path' => 'img/user.png',
        'meta_title' => $faker->title(),
        'meta_keyword' => $faker->title(),
        'meta_description' => $faker->paragraph()
    ];
});
