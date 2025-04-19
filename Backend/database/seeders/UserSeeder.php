<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Uiia',
            'email' => 'lk@gmail.com',
            'password' => Hash::make('meow'), 
            'role' => 'manager'
        ]);

        User::factory(8)->create(); 
        Student::factory(20)->create(); 

    }
}
