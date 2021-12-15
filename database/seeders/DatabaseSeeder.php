<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolepermissionSeeder::class,
        ]);

        $this->user();

        // cms4 seeders
        $this->call([
            MenuSeeder::class,
            OptionSeeder::class,
            AlbumSeeder::class,
            BannerSeeder::class,
            PageSeeder::class,
            MenusHasPagesSeeder::class,
            SettingSeeder::class,
            ArticleSeeder::class,
        ]);


        // ecommerce seeders
        $this->call([
            ProductCategorySeeder::class,
            ProductPhotoSeeder::class,
            ProductSeeder::class,
            ProductTagSeeder::class,
        ]);

        
    }

    private function user()
    {
        $users = [
            [
                'name' => 'Admin',
                'firstname' => 'admin',
                'lastname' => 'istrator',
                'email' => 'wsiprod.demo@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'is_active' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'mobile' => '09456714321',
                'phone' => '022646545',
                'address_street' => 'Maharlika St',
                'address_city' => 'Pasay',
                // 'address_province' => 'NCR',
                'address_zip' => '1234'
            ],
            [
                'name' => 'user1',
                'firstname' => 'user1',
                'lastname' => 'user1',
                'email' => 'user1@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'is_active' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'mobile' => '09456714321',
                'phone' => '022646545',
                'address_street' => 'Maharlika St',
                'address_city' => 'Pasay',
                // 'address_province' => 'NCR',
                'address_zip' => '1234'
            ],
            [
                'name' => 'user2',
                'firstname' => 'user2',
                'lastname' => 'user2',
                'email' => 'user2@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'is_active' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'mobile' => '09456714321',
                'phone' => '022646545',
                'address_street' => 'Maharlika St',
                'address_city' => 'Pasay',
                // 'address_province' => 'NCR',
                'address_zip' => '1234'
            ]
        ];

        DB::table('users')->insert($users);

    }
}
