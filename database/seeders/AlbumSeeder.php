<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Album::insert([
            [
                'name' => 'Home Banner',
                'transition_in' => 1,
                'transition_out' => 2,
                'transition' => 6,
                'type' => 'main_banner',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Sub Banner 1',
                'transition_in' => 1,
                'transition_out' => 2,
                'transition' => 6,
                'type' => 'sub_banner',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
