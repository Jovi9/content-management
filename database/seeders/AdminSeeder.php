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
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'employeeID' => '1234-454720-992',
            'firstName' => "Administrator",
            'lastName' => "Administrator",
            'department_id' => 1,
            'status' => "enable",
            'user_type_id' => 1,
            'email' => 'fjbagadiong@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->assignRole("administrator");
    }
}
