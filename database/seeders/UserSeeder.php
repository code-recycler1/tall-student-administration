<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the user seeds.
     */
    public function run(): void
    {
        // Because we all got to have the same data, we will not be using factory
        // User::factory(20)->create();

        // Insert dummy users
        $users = [
            [
                'name' => 'Michaël Cloots',
                'email' => 'michael.cloots@gmail.com',
                'admin' => true,
                'password' => Hash::make('admin1234'),
                'created_at' => now(),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Peter Peters',
                'email' => 'peter.peters@gmail.com',
                'admin' => false,
                'password' => Hash::make('user1234'),
                'created_at' => now(),
                'email_verified_at' => now()
            ]
        ];

        DB::table('users')->insert($users);
    }
}
