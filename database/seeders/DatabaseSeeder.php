<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use Database\Seeders\Menu\MainMenuSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Department::create([
            'departmentName' => 'administration'
        ]);

        $this->call([
            RoleSeeder::class,
            UserTypeSeeder::class,
            AdminSeeder::class,
            MainMenuSeeder::class
        ]);
    }
}
