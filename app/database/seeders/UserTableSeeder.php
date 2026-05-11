<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //admin user
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => '1',
            ],
                  //instructor user
                [
                    'name' => 'Instructor User',
                    'username' => 'instructor',
                    'email' => 'instructor@example.com',
                    'password' => Hash::make('222'),
                    'role' => 'instructor',
                    'status' => '1',
                ],
                //user user
                [
                    'name' => 'Regular User',
                    'username' => 'user',
                    'email' => 'user@example.com',
                    'password' => Hash::make('333'),
                    'role' => 'user',
                    'status' => '1',
                ]
        ]);
    }
}
