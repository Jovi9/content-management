<?php

namespace Database\Seeders\Menu;

use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MainMenu::create([
            'main_menu' => 'Home',
            'location' => '1'
        ]);

        MainMenu::create([
            'main_menu' => 'About',
            'location' => '2'
        ]);

        MainMenu::create([
            'main_menu' => 'Contact Us',
            'location' => '3',
        ]);

        SubMenu::create([
            'main_menu_id' => 1,
            'sub_menu' => 'None',
            'sub_location' => '1',
            'sub_status' => 'disabled'
        ]);
    }
}
