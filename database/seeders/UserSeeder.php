<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Student;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'name' => 'Liezl Kaye Roa',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), 
        ]);

        Employee::factory(100)->create(); 

        Student::create([
            'name' => 'Liezl Kaye Roa',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), 
        ]);

        Student::factory(100)->create(); 
    }
}
