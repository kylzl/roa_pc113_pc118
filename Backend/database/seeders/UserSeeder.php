<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Employee;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Liezl Kaye Roa',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('meow'), 
        //     'role' => 'admin'
        // ]);

        // User::create([
        //     'name' => 'Liezl Kaye Roa',
        //     'email' => 'lk@gmail.com',
        //     'password' => Hash::make('meow'), 
        //     'role' => 'employee'
        // ]);

        User::factory(100)->create(); 
        Student::factory(100)->create(); 
        Employee::factory(100)->create(); 

    }
}
