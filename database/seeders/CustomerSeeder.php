<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        $this->user();
    }

    private function user()
    {
        $users = [            
            [
                'name' => 'customer 1',
                'firstname' => 'customer1',
                'lastname' => 'customer1',
                'email' => 'customer1@gmail.com',
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
                'address_province' => 'NCR',
                'address_zip' => '1234'
            ],
            [
                'name' => 'customer 2',
                'firstname' => 'customer2',
                'lastname' => 'customer2',
                'email' => 'customer2@gmail.com',
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
                'address_province' => 'NCR',
                'address_zip' => '1234'
            ]
        ];

    }
}
