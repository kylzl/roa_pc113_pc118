<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Liezl Kaye Roa',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('meow'), 
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Liezl Kaye Roa',
            'email' => 'lk@gmail.com',
            'password' => Hash::make('meow'), 
            'role' => 'employee'
        ]);

        User::factory(100)->create(); 

    }
}
