<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $categories = [
            [
                'parent_id' => '0',
                'name' => 'Herbs & Spices',
                'slug' => 'herbs-&-spices',
                'description' => '',
                'status' => 'PUBLISHED',
                'created_by' => 1
            ],
            [
                'parent_id' => '0',
                'name' => 'Seasoning Blends',
                'slug' => 'seasoning-blends',
                'description' => '',
                'status' => 'PUBLISHED',
                'created_by' => 1
            ],
            [
                'parent_id' => '0',
                'name' => 'Baking',
                'slug' => 'baking',
                'description' => '',
                'status' => 'PUBLISHED',
                'created_by' => 1
            ],
            [
                'parent_id' => '0',
                'name' => 'Recipe Mix',
                'slug' => 'recipe-mix',
                'description' => '',
                'status' => 'PUBLISHED',
                'created_by' => 1
            ]
        ];

        DB::table('product_categories')->insert($categories);
    }
}
