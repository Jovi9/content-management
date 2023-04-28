<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'employeeID' => '1234-454720-992',
            'firstName' => "Website",
            'lastName' => "Administrator",
            'sex' => 'Male',
            'dateOfBirth' => '1995-01-01',
            'age' => 28,
            'placeOfBirth' => 'Catanduanes',
            'civilStatus' => 'Single',
            'department_id' => 1,
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->assignRole("administrator");
    }
}
