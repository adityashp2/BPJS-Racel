<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['id' => 1, 'name' => 'Admin', 'role' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('password'), 'job_division_id' => null],
            ['id' => 2, 'name' => 'User', 'role' => 'user', 'email' => 'user@gmail.com', 'password' => bcrypt('password'), 'job_division_id' => 2],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
