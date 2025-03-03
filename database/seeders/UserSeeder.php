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
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mohammed maher',
            'email' => 'maher@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '01273920994',
        ]);

        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'maher2@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '0122821662',
        ]);
    }
}
