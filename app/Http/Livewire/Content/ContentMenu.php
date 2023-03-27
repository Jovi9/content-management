<?php

namespace App\Http\Livewire\Content;

use App\Models\Menu\MainMenu;
use App\Models\Menu\SubMenu;
use Livewire\Component;

class ContentMenu extends Component
{
    protected $menus = array();

    public $subMenus = array(), $mainMenu;

    protected function fetchMenus()
    {
        $menus = MainMenu::all();

        foreach ($menus as $menu) {
            if (SubMenu::where('main_menu_id', $menu->id)
                ->whereNot('sub_menu', 'none')
                ->count() > 0
            ) {
                $subMenu = SubMenu::where('main_menu_id', $menu->id)->get();
                array_push($this->menus, [
                    'id' => $menu->id,
                    'main_menu' => $menu->main_menu,
                    'location' => $menu->location,
                    'status' => $menu->status,
                    'sub_menu' => $subMenu
                ]);
            } else {
                array_push($this->menus, [
                    'id' => $menu->id,
                    'main_menu' => $menu->main_menu,
                    'location' => $menu->location,
                    'status' => $menu->status,
                    'sub_menu' => 'none'
                ]);
            }
        }
    }

    public function render()
    {
        $this->fetchMenus();

        return view('livewire.content.content-menu', [
            'menus' => $this->menus
        ]);
    }

    public function showSubMenus($id)
    {
        $this->mainMenu = MainMenu::where('id', $id)->first();
        $this->subMenus = SubMenu::where('main_menu_id', $id)->get();
    }

    public function resetForm()
    {
        $this->reset();
    }
}
