<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Banner::insert([
            [
                'album_id' => 1,
                'image_path' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/banner/slide-1.png',
                'title' => 'Learning Excellence',
                'description' => 'Education is a commitment to excellence in Teaching and Learning',
                'alt' => 'Banner 1',
                'url' => \URL::to('/'),
                'order' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'album_id' => 1,
                'image_path' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/banner/slide-1.png',
                'title' => 'Lorem ipsum2',
                'description' => 'Lorem ipsum2 Lorem ipsum2 Lorem ipsum2 Lorem ipsum2',
                'alt' => 'Banner 2',
                'url' => \URL::to('/'),
                'order' => 2,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'album_id' => 1,
                'image_path' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/banner/slide-1.png',
                'title' => 'Lorem ipsum3',
                'description' => 'Lorem ipsum3 Lorem ipsum3 Lorem ipsum3 Lorem ipsum3',
                'alt' => 'Banner 3',
                'url' => \URL::to('/'),
                'order' => 3,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'album_id' => 2,
                'image_path' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/subbanner.jpg',
                'title' => null,
                'description' => null,
                'alt' => null,
                'url' => null,
                'order' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'album_id' => 2,
                'image_path' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/subbanner.jpg',
                'title' => null,
                'description' => null,
                'alt' => null,
                'url' => null,
                'order' => 2,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'album_id' => 2,
                'image_path' => \URL::to('/').'/theme/'.env('THEME_FOLDER').'/images/subbanner.jpg',
                'title' => null,
                'description' => null,
                'alt' => null,
                'url' => null,
                'order' => 3,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
