<?php

namespace Database\Seeders\Menu;

use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainMenuSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MainMenu::create([
            'mainMenu' => 'none',
            'mainURI'=>'none',
        ]);

        SubMenu::create([
            'main_menu_id' => 1,
            'subMenu' => 'none',
            'subURI'=>'none',
        ]);

        // MainMenu::create([
        //     'mainMenu' => 'Test 1',
        // ]);

        // MainMenu::create([
        //     'mainMenu' => 'Test 2 w/ Sub',
        // ]);

        // SubMenu::create([
        //     'main_menu_id' => 3,
        //     'subMenu' => 'Sub Test 1',
        // ]);
    }
}
