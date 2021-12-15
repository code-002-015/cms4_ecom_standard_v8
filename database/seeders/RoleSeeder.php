<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            'name' => 'Admin',
            'description' => 'Administrator of the system',
            'created_by' => 1
        ]);
    }
}
